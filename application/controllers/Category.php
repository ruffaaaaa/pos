<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('authModel');
        $this->load->model('supplierModel'); 
        $this->load->model('customerModel'); 
        $this->load->model('categoryModel'); 
        $this->load->library('session');
        $this->load->helper(array('url', 'form'));

        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
        
        if ($this->session->userdata('role') === 'cashier') {
            $this->session->set_flashdata('error', 'You are not allowed to access.');
            redirect('category');
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
            'location' => $this->session->userdata('location'),
            'created_at'  => date('Y-m-d H:i:s')
        ]);
    }

    public function index() {
        $data['categories'] = $this->categoryModel->get_all();
    
        // Pass $data to the view
        $this->load->view('main', [
            'content_view' => 'dashboard/category_content',
            'data' => $data  // Pass data to the content view
        ]);
    }
    
    // Store Category
    public function store() {
        $this->form_validation->set_rules('category_name', 'Category Name', 'required');
    
        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('category');
        } else {
            $data = [
                'category_name' => $this->input->post('category_name'),
            ];
    
            $this->categoryModel->insert($data);
            $insert_id = $this->db->insert_id();
    
            $this->log_action('Category', $insert_id, 'Created', null, $data, 'New category added');
    
            $this->session->set_flashdata('success', 'Category added successfully.');
            redirect('categories');
        }
    }


    public function update() {
        $id = $this->input->post('category_id');
        $this->form_validation->set_rules('category_name', 'Category Name', 'required');
    
        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('category');
        } else {
            $new_data = [
                'category_name' => $this->input->post('category_name'),
            ];
    
            $old_data = $this->db->get_where('tbl_categories', ['category_id' => $id])->row_array();
    
            $this->categoryModel->update($id, $new_data);
    
            $this->log_action('Category', $id, 'Updated', $old_data, $new_data, 'Category updated');
    
            $this->session->set_flashdata('success', 'Category updated successfully.');
            redirect('categories');
        }
    }


    public function delete($id) {
        $this->load->model('productModel');
        $product_count = $this->productModel->count_by_category($id);
    
        if ($product_count > 0) {
            $this->session->set_flashdata('error', 'Cannot delete this category because it is assigned to one or more products.');
            redirect('category');
        } else {
            $old_data = $this->db->get_where('tbl_categories', ['category_id' => $id])->row_array();
            $this->categoryModel->delete($id);
    
            $this->log_action('Category', $id, 'Deleted', $old_data, null, 'Category deleted');
    
            $this->session->set_flashdata('success', 'Category deleted successfully.');
            redirect('categories');
        }
    }


}
