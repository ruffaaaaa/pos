<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH . 'vendor/autoload.php'; 


use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
class Inventory extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('authModel');
        $this->load->model('supplierModel'); 
        $this->load->model('inventoryModel');
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
            $this->session->set_flashdata('error', 'You are not allowed to access.');
            redirect('inventory');
        }
    }

    private function log_action($table, $record_id, $action, $old = null, $new = null, $description = '') {
        $this->db->insert('tbl_logs', [
            'user_id'     => $this->session->userdata('user_id'),
            'table_name'  => $table,
            'record_id'   => $record_id,
            'action'      => $action,
            'old_data'    => $old ? json_encode($old) : null,
            'new_data'    => $new ? json_encode($new) : null,
            'description' => $description,
            'created_at'  => date('Y-m-d H:i:s'),
            'location' => $this->session->userdata('location'),

        ]);
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
        $barcode = $this->input->post('barcode');
        $product_name = $this->input->post('product_name');
        $category_id = $this->input->post('category_id');
        $unit_id = $this->input->post('unit_id');
        $cost_price = $this->input->post('cost_price');
        $retail_price = $this->input->post('retail_price');
        $description = $this->input->post('description');
        $stock_in = $this->input->post('stock_in');
    
        $product_data = [
            'barcode' => $barcode,
            'product_name' => $product_name,
            'category_id' => $category_id,
            'unit_id' => $unit_id,
            'cost_price' => $cost_price,
            'retail_price' => $retail_price,
            'description' => $description,
        ];
        $this->db->insert('tbl_products', $product_data);
        $product_id = $this->db->insert_id();
    
        $inventory_data = [
            'product_id' => $product_id,
            'stock_in' => $stock_in,
            'stock_out' => 0,
            'current_stock' => $stock_in,
            'last_updated' => date('Y-m-d H:i:s'),
            'location' => $this->session->userdata('location')
        ];
        $this->db->insert('tbl_inventory', $inventory_data);
        $inventory_id = $this->db->insert_id();
    
        // Log action
        $this->log_action('Inventory', $inventory_id, 'insert', null, $inventory_data, 'Inventory added manually');
    
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
                
                $this->log_action('Inventory', $this->db->insert_id(), 'insert', null, $inventory_data, 'Inventory added via Excel upload');

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

        return $category ? $category->category_id : null; // Or handle error if needed
    }

    private function get_unit_id_by_name($unit_name) {
        // Check if unit name exists
        $query = $this->db->get_where('tbl_units', ['unit_name' => $unit_name]);
        $unit = $query->row();

        return $unit ? $unit->unit_id : null; 
    }
    
    public function delete($inventory_id) {
        $query = $this->db->get_where('tbl_inventory', ['inventory_id' => $inventory_id]);
        if ($query->num_rows() > 0) {
            $inventory = $query->row();
    
            $product = $this->db->get_where('tbl_products', ['product_id' => $inventory->product_id])->row();
    
            $this->db->delete('tbl_inventory', ['inventory_id' => $inventory_id]);
            $this->db->delete('tbl_products', ['product_id' => $inventory->product_id]);
    
            // Log deletion
            $this->log_action('Inventory', $inventory_id, 'delete', $inventory, null, 'Inventory deleted');

            $this->session->set_flashdata('success', 'Deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Product not found.');
        }
    
        redirect('inventory');
    }



    public function edit() {
        $inventory_id = $this->input->post('inventory_id');
        $product_name = $this->input->post('product_name');
        $stock_in = $this->input->post('stock_in');
        $stock_out = $this->input->post('stock_out');
        $current_stock = $this->input->post('current_stock');
        $product_id = $this->input->post('product_id');
    
        if ($stock_in === null || $stock_out === null) {
            $this->session->set_flashdata('error', 'Stock In and Stock Out are required.');
            redirect('inventory');
        }
    
        $old_inventory = $this->db->get_where('tbl_inventory', ['inventory_id' => $inventory_id])->row();
        $old_product = $this->db->get_where('tbl_products', ['product_id' => $product_id])->row();
    
        $calculated_current_stock = $stock_in - $stock_out;
    
        $this->db->where('inventory_id', $inventory_id);
        $this->db->update('tbl_inventory', [
            'stock_in' => $stock_in,
            'stock_out' => $stock_out,
            'current_stock' => $calculated_current_stock,
            'last_updated' => date('Y-m-d H:i:s')
        ]);
    
        $this->db->where('product_id', $product_id);
        $this->db->update('tbl_products', [
            'product_name' => $product_name
        ]);
    
        // Fetch new data for logging
        $new_inventory = $this->db->get_where('tbl_inventory', ['inventory_id' => $inventory_id])->row();
        $new_product = $this->db->get_where('tbl_products', ['product_id' => $product_id])->row();
    
        $this->log_action('Inventory', $inventory_id, 'update', $old_inventory, $new_inventory, 'Inventory updated');

        $this->session->set_flashdata('success', 'Inventory updated successfully.');
        redirect('inventory');
    }




}

