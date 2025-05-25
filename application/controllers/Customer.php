<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('authModel');
        $this->load->model('supplierModel'); 
        $this->load->model('customerModel'); 
        $this->load->library('session');
        $this->load->helper(array('url', 'form'));

        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
    }


    public function index() {
        $data['customers'] = $this->customerModel->get_all();
    
        // Pass $data to the view
        $this->load->view('main', [
            'content_view' => 'dashboard/customer_content',
            'data' => $data  // Pass data to the content view
        ]);
    }
    

    public function store() {
        // Set validation rules
        $this->form_validation->set_rules('customer_name', 'Customer Name', 'required');
        $this->form_validation->set_rules('phone_number', 'Phone Number', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        // Check if the form is valid
        if ($this->form_validation->run() == FALSE) {
            // Clean the validation errors to remove <p> tags for better display in toast
            $error_message = strip_tags(validation_errors());

            // Set flashdata error message
            $this->session->set_flashdata('error', $error_message);

            // Redirect back to form
            redirect('customers');
        } else {
            // Prepare the data to be saved
            $data = [
                'customer_name' => $this->input->post('customer_name'),
                'phone_number'  => $this->input->post('phone_number'),
                'email'         => $this->input->post('email'),
                'address'       => $this->input->post('address'),
            ];

            // Insert data into the customer table
            if ($this->customerModel->insert($data)) {
                $this->session->set_flashdata('success', 'Customer added successfully.');
            } else {
                $this->session->set_flashdata('error', 'Failed to add customer. Please try again.');
            }

            // Redirect to customer list
            redirect('customers');
        }
    }


    public function update() {
        $id = $this->input->post('customer_id');
        $data = [
            'customer_name' => $this->input->post('customer_name'),
            'phone_number'  => $this->input->post('phone_number'),
            'email'         => $this->input->post('email'),
            'address'       => $this->input->post('address')
        ];

        $this->customerModel->update($id, $data);
        $this->session->set_flashdata('success', 'Customer updated successfully.');
        redirect('customers');
    }

    public function delete($id = null){
        if ($id === null) {
            $this->session->set_flashdata('error', 'Invalid supplier ID.');
            redirect('customers');
            return;
        }

        $deleted = $this->customerModel->delete($id);

        if ($deleted) {
            $this->session->set_flashdata('success', 'Supplier deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete supplier.');
        }

        redirect('customers');
    }



}

// Controller: Auth.php
