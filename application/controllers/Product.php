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
        $this->session->set_flashdata('error', 'You are not allowed to access the dashboard.');
        redirect('pos'); // or any other page for cashiers
    }
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
            redirect('products');  // Redirect back to products page
        } else {
            $data = [
                'barcode'         => $this->input->post('barcode'),
                'product_name'    => $this->input->post('product_name'),
                'category_id'     => $this->input->post('category_id'),
                'unit_id'         => $this->input->post('unit_id'),
                'price'           => $this->input->post('price'),
                'stock_quantity'  => 0,
                'status'          => 'active'  // Default status set to active
            ];

            $this->productModel->insert($data);
            $this->session->set_flashdata('success', 'Product added successfully.');
            redirect('products');
        }
    }

    public function edit() {
        // Get data from the form
        $product_id = $this->input->post('product_id');
        $barcode = $this->input->post('barcode');
        $product_name = $this->input->post('product_name');
        $category_id = $this->input->post('category_id');
        $unit_id = $this->input->post('unit_id');
        $cost_price = $this->input->post('cost_price');
        $retail_price = $this->input->post('retail_price');
        $description = $this->input->post('description');

        // Validate required fields
        if (empty($product_name) || empty($barcode) || empty($category_id) || empty($unit_id) || empty($cost_price) || empty($retail_price)) {
            $this->session->set_flashdata('error', 'Please fill in all required fields.');
            redirect('product'); // Adjust redirect as needed
        }

        // Prepare data for update
        $update_data = [
            'barcode' => $barcode,
            'product_name' => $product_name,
            'category_id' => $category_id,
            'unit_id' => $unit_id,
            'cost_price' => $cost_price,
            'retail_price' => $retail_price,
            'description' => $description
        ];

        // Update product in database
        $this->db->where('product_id', $product_id);
        $this->db->update('tbl_products', $update_data);

        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata('success', 'Product updated successfully.');
        } else {
            $this->session->set_flashdata('info', 'No changes were made.');
        }

        redirect('products'); // Adjust redirect as needed
    }


    public function delete($id = null){
        if ($id === null) {
            $this->session->set_flashdata('error', 'Invalid supplier ID.');
            redirect('products');
            return;
        }

        $deleted = $this->productModel->delete($id);

        if ($deleted) {
            $this->session->set_flashdata('success', 'Product deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete supplier.');
        }

        redirect('products');
    }


}

// Controller: Auth.php
