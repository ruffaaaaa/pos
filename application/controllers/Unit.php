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
            redirect('units');  // Your main units page
        } else {
            $data = [
                'unit_name'    => $this->input->post('unit_name'),
                'abbreviation' => $this->input->post('abbreviation'),
                'status'       => 'active'  // Default status
            ];

            $this->unitModel->insert($data);  // Call model to insert
            $this->session->set_flashdata('success', 'Unit added successfully.');
            redirect('units');
        }
    }

public function update()
{
    $unit_id = $this->input->post('unit_id');
    $unit_name = $this->input->post('unit_name');
    $abbreviation = $this->input->post('abbreviation');

    $data = [
        'unit_name' => $unit_name,
        'abbreviation' => $abbreviation,
    ];

    $this->db->where('unit_id', $unit_id);
    $updated = $this->db->update('tbl_units', $data);

    if ($updated) {
        $this->session->set_flashdata('success', 'Unit updated successfully.');
    } else {
        $this->session->set_flashdata('error', 'Failed to update unit.');
    }

    redirect('unit'); // or wherever your unit list is
}


    public function delete($id) {
        if ($this->unitModel->delete($id)) {
            $this->session->set_flashdata('success', 'Unit deleted successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete unit.');
        }
        redirect('units');
    }



}

// Controller: Auth.php
