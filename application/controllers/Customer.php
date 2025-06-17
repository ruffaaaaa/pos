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
        
        if ($this->session->userdata('role') === 'cashier') {
            $this->session->set_flashdata('error', 'You are not allowed to access.');
            redirect('customers');
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
        $data['customers'] = $this->customerModel->get_all();
    
        // Pass $data to the view
        $this->load->view('main', [
            'content_view' => 'dashboard/customer_content',
            'data' => $data  // Pass data to the content view
        ]);
    }
    

    public function store() {
        $this->form_validation->set_rules('customer_name', 'Customer Name', 'required');
        $this->form_validation->set_rules('phone_number', 'Phone Number', 'required');

        if ($this->form_validation->run() == FALSE) {
            $error_message = strip_tags(validation_errors());
            $this->session->set_flashdata('error', $error_message);
            redirect('customers');
        } else {
            $data = [
                'customer_name' => $this->input->post('customer_name'),
                'phone_number'  => $this->input->post('phone_number'),
                'email'         => $this->input->post('email'),
                'address'       => $this->input->post('address'),
            ];
    
            if ($this->customerModel->insert($data)) {
                $insert_id = $this->db->insert_id();
    
                // 🔍 Log the insertion
                $this->log_action('Customers', $insert_id, 'insert', null, $data, 'Added new customer');
    
                $this->session->set_flashdata('success', 'Customer added successfully.');
            } else {
                $this->session->set_flashdata('error', 'Failed to add customer. Please try again.');
            }
    
            redirect('customers');
        }
    }


    public function update() {
        $id = $this->input->post('customer_id');
        
        $new_data = [
            'customer_name' => $this->input->post('customer_name'),
            'phone_number'  => $this->input->post('phone_number'),
            'email'         => $this->input->post('email'),
            'address'       => $this->input->post('address')
        ];
    
        // Get old data for logging
        $old_data = $this->db->get_where('tbl_customers', ['customer_id' => $id])->row_array();
    
        $this->customerModel->update($id, $new_data);
    
        // 🔍 Log the update
        $this->log_action('Customers', $id, 'update', $old_data, $new_data, 'Updated customer');
    
        $this->session->set_flashdata('success', 'Customer updated successfully.');
        redirect('customers');
    }


    public function delete($id = null){
        if ($id === null) {
            $this->session->set_flashdata('error', 'Invalid customer ID.');
            redirect('customers');
            return;
        }
    
        // Get old data before deletion for logging
        $old_data = $this->db->get_where('tbl_customers', ['customer_id' => $id])->row_array();
    
        if (!$old_data) {
            $this->session->set_flashdata('error', 'Customer not found.');
            redirect('customers');
            return;
        }
    
        $deleted = $this->customerModel->delete($id);
    
        if ($deleted) {
            // 🔍 Log the deletion
            $this->log_action('Customers', $id, 'delete', $old_data, null, 'Deleted customer');
            $this->session->set_flashdata('success', 'Customer deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete customer.');
        }
    
        redirect('customers');
    }



}

// Controller: Auth.php
