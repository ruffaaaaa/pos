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
            $this->session->set_flashdata('success', 'Category added successfully.');
            redirect('category');
        }
    }

    public function update() {
        $id = $this->input->post('category_id');
        $this->form_validation->set_rules('category_name', 'Category Name', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('category');
        } else {
            $data = [
                'category_name' => $this->input->post('category_name'),
            ];

            $this->categoryModel->update($id, $data);
            $this->session->set_flashdata('success', 'Category updated successfully.');
            redirect('category');
        }
    }


    public function delete($id) {
        // Check if category has related products
        $this->load->model('productModel');
        $product_count = $this->productModel->count_by_category($id);

        if ($product_count > 0) {
            $this->session->set_flashdata('error', 'Cannot delete this category because it is assigned to one or more products.');
            redirect('category');
        } else {
            $this->categoryModel->delete($id);
            $this->session->set_flashdata('success', 'Category deleted successfully.');
            redirect('category');
        }
    }

}
