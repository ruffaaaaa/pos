<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('authModel');
        $this->load->model('supplierModel'); 
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
        $data['suppliers'] = $this->supplierModel->get_all();
    
        // Pass $data to the view
        $this->load->view('main', [
            'content_view' => 'dashboard/supplier_content',
            'data' => $data  // Pass data to the content view
        ]);
    }
    

    public function store() {
        $this->form_validation->set_rules('supplier_name', 'Supplier Name', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('suppliers');
        } else {
            $data = [
                'supplier_name'   => $this->input->post('supplier_name'),
                'contact_person'  => $this->input->post('contact_person'),
                'phone_number'    => $this->input->post('phone_number'),
                'email'           => $this->input->post('email'),
                'address'         => $this->input->post('address'),
                'status'          => 'active'
            ];

            $this->supplierModel->insert($data);

            // 🔒 Log creation
            $log = [
                'user_id'    => $this->session->userdata('user_id'),
                'table_name' => 'Supplier',
                'record_id'  => $this->db->insert_id(),
                'action'     => 'Created',
                'old_data'   => null,
                'new_data'   => json_encode($data),
                'description'=> 'Supplier created',
                'created_at' => date('Y-m-d H:i:s'),
                'location' => $this->session->userdata('location'),

            ];
            $this->db->insert('tbl_logs', $log);

            $this->session->set_flashdata('success', 'Supplier added successfully.');
            redirect('suppliers');
        }
    }


        public function edit(){
        $id = $this->input->post('supplier_id');

        if (empty($id) || !$this->input->post('supplier_name')) {
            $this->session->set_flashdata('error', 'Invalid input. Please fill all required fields.');
            redirect('suppliers');
            return;
        }

        $data = array(
            'supplier_name'  => $this->input->post('supplier_name'),
            'contact_person' => $this->input->post('contact_person'),
            'phone_number'   => $this->input->post('phone_number'),
            'email'          => $this->input->post('email'),
            'address'        => $this->input->post('address'),
            'status'         => $this->input->post('status')
        );

        try {
            // 📦 Get old data before update
            $old_data = $this->supplierModel->get_by_id($id);

            $result = $this->supplierModel->update($id, $data);

            if ($result) {
                // 🔒 Log update
                $log = [
                    'user_id'    => $this->session->userdata('user_id'),
                    'table_name' => 'tbl_suppliers',
                    'record_id'  => $id,
                    'action'     => 'Updated',
                    'old_data'   => json_encode($old_data),
                    'new_data'   => json_encode($data),
                    'description'=> 'Supplier updated',
                    'created_at' => date('Y-m-d H:i:s')
                ];
                $this->db->insert('tbl_logs', $log);

                $this->session->set_flashdata('success', 'Supplier updated successfully.');
            } else {
                $this->session->set_flashdata('error', 'Failed to update supplier. Please try again.');
            }
        } catch (Exception $e) {
            log_message('error', 'Supplier update failed: ' . $e->getMessage());
            $this->session->set_flashdata('error', 'An error occurred while updating the supplier.');
        }

        redirect('suppliers');
    }


    public function delete($id = null)
    {
        if ($id === null) {
            $this->session->set_flashdata('error', 'Invalid supplier ID.');
            redirect('suppliers');
            return;
        }

        $old_data = $this->supplierModel->get_by_id($id);

        $deleted = $this->supplierModel->delete($id);

        if ($deleted) {
            $log = [
                'user_id'    => $this->session->userdata('user_id'),
                'table_name' => 'Supplier',
                'record_id'  => $id,
                'action'     => 'Deleted',
                'old_data'   => json_encode($old_data),
                'new_data'   => null,
                'description'=> 'Supplier deleted',
                'created_at' => date('Y-m-d H:i:s')
            ];
            $this->db->insert('tbl_logs', $log);

            $this->session->set_flashdata('success', 'Supplier deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete supplier.');
        }

        redirect('suppliers');
    }



}

