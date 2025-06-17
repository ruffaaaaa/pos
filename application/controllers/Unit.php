<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unit extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('authModel');
        $this->load->model('supplierModel'); 
        $this->load->model('customerModel'); 
        $this->load->model('categoryModel'); 
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
        $data['units'] = $this->unitModel->get_all();
    
        $this->load->view('main', [
            'content_view' => 'dashboard/unit_content',
            'data' => $data 
        ]);
    }
    

    public function store() {
        $this->form_validation->set_rules('unit_name', 'Unit Name', 'required');
        $this->form_validation->set_rules('abbreviation', 'Abbreviation', 'required');
    
        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('units');
        } else {
            $data = [
                'unit_name'    => $this->input->post('unit_name'),
                'abbreviation' => $this->input->post('abbreviation'),
            ];
    
            $this->unitModel->insert($data);
            $insert_id = $this->db->insert_id();
    
            // 🔒 Log create
            $log = [
                'user_id'    => $this->session->userdata('user_id'),
                'table_name' => 'Units',
                'record_id'  => $insert_id,
                'action'     => 'Created',
                'old_data'   => null,
                'new_data'   => json_encode($data),
                'description'=> 'Unit created',
                'created_at' => date('Y-m-d H:i:s'),
                'location' => $this->session->userdata('location'),

            ];
            $this->db->insert('tbl_logs', $log);
    
            $this->session->set_flashdata('success', 'Unit added successfully.');
            redirect('units');
        }
    }
    
    
    public function update()
    {
        $unit_id     = $this->input->post('unit_id');
        $unit_name   = $this->input->post('unit_name');
        $abbreviation = $this->input->post('abbreviation');
    
        $new_data = [
            'unit_name' => $unit_name,
            'abbreviation' => $abbreviation,
        ];
    
        // 📦 Get old data first
        $old_data = $this->db->get_where('tbl_units', ['unit_id' => $unit_id])->row_array();
    
        $this->db->where('unit_id', $unit_id);
        $updated = $this->db->update('tbl_units', $new_data);
    
        if ($updated) {
            // 🔒 Log update
            $log = [
                'user_id'    => $this->session->userdata('user_id'),
                'table_name' => 'Units',
                'record_id'  => $unit_id,
                'action'     => 'Updated',
                'old_data'   => json_encode($old_data),
                'new_data'   => json_encode($new_data),
                'description'=> 'Unit updated',
                'created_at' => date('Y-m-d H:i:s')
            ];
            $this->db->insert('tbl_logs', $log);
    
            $this->session->set_flashdata('success', 'Unit updated successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to update unit.');
        }
    
        redirect('unit');
    }
    
    
    public function delete($id) {
        // 📦 Get old data before delete
        $old_data = $this->db->get_where('tbl_units', ['unit_id' => $id])->row_array();
    
        if ($this->unitModel->delete($id)) {
            // 🔒 Log delete
            $log = [
                'user_id'    => $this->session->userdata('user_id'),
                'table_name' => 'Units',
                'record_id'  => $id,
                'action'     => 'Deleted',
                'old_data'   => json_encode($old_data),
                'new_data'   => null,
                'description'=> 'Unit deleted',
                'created_at' => date('Y-m-d H:i:s')
            ];
            $this->db->insert('tbl_logs', $log);
    
            $this->session->set_flashdata('success', 'Unit deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete unit.');
        }
    
        redirect('units');
    }



}

// Controller: Auth.php
