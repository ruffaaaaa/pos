<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH . 'vendor/autoload.php'; // Make sure to include this line at the top


use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
class Inventory extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('authModel');
        $this->load->model('supplierModel'); 
        $this->load->model('inventoryModel'); // Load the Inventory model
        $this->load->model('customerModel');
        $this->load->model('categoryModel');
        $this->load->model('productModel');
        $this->load->model('unitModel');
        $this->load->library(array('session', 'upload'));
        $this->load->helper(array('url', 'form'));
        
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }

         if ($this->session->userdata('role') === 'cashier') {
        $this->session->set_flashdata('error', 'You are not allowed to access the dashboard.');
        redirect('pos'); // or any other page for cashiers
    }
    }


    public function index() {
    
        $data['inventory'] = $this->inventoryModel->get_all();
        $data['products'] = $this->productModel->get_all();
        $data['categories'] = $this->categoryModel->get_all(); 
        $data['units'] = $this->unitModel->get_all();

        $this->load->view('main', [
            'content_view' => 'dashboard/inventory_content',
            'data' => $data  
        ]);
    }
    
    public function add_product() {
        // Get form input values
        $barcode = $this->input->post('barcode');
        $product_name = $this->input->post('product_name');
        $category_id = $this->input->post('category_id');
        $unit_id = $this->input->post('unit_id');
        $cost_price = $this->input->post('cost_price');
        $retail_price = $this->input->post('retail_price');
        $description = $this->input->post('description');
        $stock_in = $this->input->post('stock_in');



        // Insert new product into the 'tbl_products' table
        $this->db->insert('tbl_products', [
            'barcode' => $barcode,
            'product_name' => $product_name,
            'category_id' => $category_id,
            'unit_id' => $unit_id,
            'cost_price' => $cost_price,
            'retail_price' => $retail_price,
            'description' => $description,
        ]);

        // Get the inserted product's ID
        $product_id = $this->db->insert_id();

        // Insert the initial stock into the 'tbl_inventory' table
        $this->db->insert('tbl_inventory', [
            'product_id' => $product_id,
            'stock_in' => $stock_in,
            'stock_out' => 0,
            'current_stock' => $stock_in, // Assuming current stock is equal to stock in at the time of addition
            'last_updated' => date('Y-m-d H:i:s')
        ]);


        // Redirect back to inventory page with a success message
        $this->session->set_flashdata('success', 'Product added successfully.');
        redirect('inventory');
    }

    
    public function upload_excel() {
        // Configure file upload settings
        $config['upload_path'] = FCPATH . './uploads/'; // Ensure this folder exists and is writable
        $config['allowed_types'] = 'xls|xlsx';
        $config['max_size'] = 10240; // 10MB max size

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('excelFile')) {
            // Upload failed
            $this->session->set_flashdata('error', $this->upload->display_errors());
            redirect('inventory');
        } else {
            // Get file data
            $file_data = $this->upload->data();
            $file_path = './uploads/' . $file_data['file_name'];

            // Parse the Excel file
            $spreadsheet = IOFactory::load($file_path);
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray(); // Convert all rows to an array

            unset($rows[0]);

            foreach ($rows as $row) {
                // Extract and sanitize data
                $barcode        = trim($row[0]);
                $product_name   = trim($row[1]);
                $category_name  = trim($row[2]);
                $unit_name      = trim($row[3]);
                $cost_price     = (float) $row[4];
                $retail_price   = (float) $row[5];
                $description    = trim($row[6]);
                $stock_in       = (int) $row[7];
                $stock_out      = (int) $row[8];
                $current_stock  = (int) $row[9];

                // Get or create category and unit IDs
                $category_id = $this->get_category_id_by_name($category_name);
                $unit_id     = $this->get_unit_id_by_name($unit_name);

                // Insert into tbl_products
                $product_data = [
                    'barcode'       => $barcode,
                    'product_name'  => $product_name,
                    'category_id'   => $category_id,
                    'unit_id'       => $unit_id,
                    'cost_price'    => $cost_price,
                    'retail_price'  => $retail_price,
                    'description'   => $description
                ];
                $this->db->insert('tbl_products', $product_data);
                $product_id = $this->db->insert_id();

                // Insert into tbl_inventory
                $inventory_data = [
                    'product_id'    => $product_id,
                    'stock_in'      => $stock_in,
                    'stock_out'     => $stock_out,
                    'current_stock' => $current_stock
                ];
                $this->db->insert('tbl_inventory', $inventory_data);
            }
            // Set flashdata for success message
            $this->session->set_flashdata('success', 'Import Successfully');
            redirect('inventory');
        }
    }

    private function get_category_id_by_name($category_name) {
        // Check if category name exists
        $query = $this->db->get_where('tbl_categories', ['category_name' => $category_name]);
        $category = $query->row();

        // If category does not exist, you can either:
        // - Return a default category_id (if applicable)
        // - Return an error or handle accordingly
        return $category ? $category->category_id : null; // Or handle error if needed
    }

    private function get_unit_id_by_name($unit_name) {
        // Check if unit name exists
        $query = $this->db->get_where('tbl_units', ['unit_name' => $unit_name]);
        $unit = $query->row();

        return $unit ? $unit->unit_id : null; 
    }
    
    public function delete($inventory_id) {
        // Check if the inventory item exists
        $query = $this->db->get_where('tbl_inventory', ['inventory_id' => $inventory_id]);
        if ($query->num_rows() > 0) {
            $inventory = $query->row();

            $this->db->delete('tbl_inventory', ['inventory_id' => $inventory_id]);

            $this->db->delete('tbl_products', ['product_id' => $inventory->product_id]);

            $this->session->set_flashdata('success', 'Deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Product not found.');
        }

        redirect('inventory');
    }


    public function edit() {
        // Get data from the form
        $inventory_id = $this->input->post('inventory_id');
        $stock_in = $this->input->post('stock_in');
        $stock_out = $this->input->post('stock_out');
        $current_stock = $this->input->post('current_stock');

        // Validate required fields
        if ($stock_in === null || $stock_out === null) {
            $this->session->set_flashdata('error', 'Stock In and Stock Out are required.');
            redirect('inventory');
        }

        // Since current_stock input is disabled, it won't be posted
        // So calculate current stock here if needed:
        $calculated_current_stock = $stock_in - $stock_out;

        // Update the inventory data only
        $this->db->where('inventory_id', $inventory_id);
        $this->db->update('tbl_inventory', [
            'stock_in' => $stock_in,
            'stock_out' => $stock_out,
            'current_stock' => $calculated_current_stock,
            'last_updated' => date('Y-m-d H:i:s')
        ]);

        $this->session->set_flashdata('success', 'Inventory updated successfully.');
        redirect('inventory');
    }



}

