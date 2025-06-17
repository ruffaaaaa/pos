<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('authModel');
        $this->load->model('supplierModel'); 
        $this->load->model('customerModel'); 
        $this->load->model('categoryModel'); 
        $this->load->model('productModel'); 
        $this->load->model('unitModel'); 
        $this->load->library('session');
        $this->load->helper(array('url', 'form'));

        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
        
        if ($this->session->userdata('role') === 'cashier') {
            $this->session->set_flashdata('error', 'You are not allowed to access.');
            redirect('products');
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
        $data['products'] = $this->productModel->get_all();
        $data['categories'] = $this->categoryModel->get_all(); 
        $data['units'] = $this->unitModel->get_all();

        $this->load->view('main', [
            'content_view' => 'dashboard/product_content',
            'data' => $data
        ]);
    }

    
    public function store() {
        $this->form_validation->set_rules('barcode', 'Barcode', 'required');
        $this->form_validation->set_rules('product_name', 'Product Name', 'required');
        $this->form_validation->set_rules('category_id', 'Category', 'required');
        $this->form_validation->set_rules('unit_id', 'Unit', 'required');
        $this->form_validation->set_rules('price', 'Price', 'required|numeric');
    
        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('products');
        } else {
            $data = [
                'barcode'         => $this->input->post('barcode'),
                'product_name'    => $this->input->post('product_name'),
                'category_id'     => $this->input->post('category_id'),
                'unit_id'         => $this->input->post('unit_id'),
                'price'           => $this->input->post('price'),
                'stock_quantity'  => 0,
                'status'          => 'active'
            ];
    
            $this->db->insert('tbl_products', $data);
            $product_id = $this->db->insert_id();
    
            // 🔍 Log the insertion
            $this->log_action('Products', $product_id, 'insert', null, $data, 'Added new product');
    
            $this->session->set_flashdata('success', 'Product added successfully.');
            redirect('products');
        }
    }

    
    public function edit() {
        $product_id = $this->input->post('product_id');
        $barcode = $this->input->post('barcode');
        $product_name = $this->input->post('product_name');
        $category_id = $this->input->post('category_id');
        $unit_id = $this->input->post('unit_id');
        $cost_price = $this->input->post('cost_price');
        $retail_price = $this->input->post('retail_price');
        $description = $this->input->post('description');
    
        if (empty($product_name) || empty($barcode) || empty($category_id) || empty($unit_id) || empty($cost_price) || empty($retail_price)) {
            $this->session->set_flashdata('error', 'Please fill in all required fields.');
            redirect('product');
        }
    
        $update_data = [
            'barcode' => $barcode,
            'product_name' => $product_name,
            'category_id' => $category_id,
            'unit_id' => $unit_id,
            'cost_price' => $cost_price,
            'retail_price' => $retail_price,
            'description' => $description
        ];
    
        // Get old data before update
        $old_data = $this->db->get_where('tbl_products', ['product_id' => $product_id])->row_array();
    
        // Update product
        $this->db->where('product_id', $product_id);
        $this->db->update('tbl_products', $update_data);
    
        if ($this->db->affected_rows() > 0) {
            // 🔍 Log the update
            $this->log_action('Products', $product_id, 'update', $old_data, $update_data, 'Updated product');
            $this->session->set_flashdata('success', 'Product updated successfully.');
        } else {
            $this->session->set_flashdata('info', 'No changes were made.');
        }
    
        redirect('products');
    }



    public function delete($id = null) {
        if ($id === null) {
            $this->session->set_flashdata('error', 'Invalid product ID.');
            redirect('products');
            return;
        }
    
        // Get product data before deletion for logging
        $old_data = $this->db->get_where('tbl_products', ['product_id' => $id])->row_array();
    
        if (!$old_data) {
            $this->session->set_flashdata('error', 'Product not found.');
            redirect('products');
            return;
        }
    
        $deleted = $this->productModel->delete($id);
    
        if ($deleted) {
            // 🔍 Log the delete action
            $this->log_action('Products', $id, 'delete', $old_data, null, 'Deleted product');
            $this->session->set_flashdata('success', 'Product deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete product.');
        }
    
        redirect('products');
    }


}

// Controller: Auth.php
