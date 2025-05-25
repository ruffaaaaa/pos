<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('authModel');
        $this->load->model('supplierModel'); 
        $this->load->model('customerModel'); 
        $this->load->model('categoryModel'); 
        $this->load->model('unitModel'); 
        $this->load->model('productModel'); 
        $this->load->model('inventoryModel');   
        $this->load->model('salesModel');   
        $this->load->model('userModel');

        $this->load->library('session');
        $this->load->helper(array('url', 'form'));

        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
    }


    public function index() {
        $data['users'] = $this->userModel->get_all();
    
        $this->load->view('main', [
            'content_view' => 'dashboard/user_content',
            'data' => $data 
        ]);
    }
    

    public function store() {
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[tbl_users.username]');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('role', 'Role', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('users');
        } else {
            $data = [
                'name'     => $this->input->post('name'),
                'username' => $this->input->post('username'),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'role'     => $this->input->post('role'),
                'isActive' => 1 // Default to active
            ];

            $this->userModel->insert($data);  // Assumes your model inserts into tbl_users
            $this->session->set_flashdata('success', 'User added successfully.');
            redirect('users');
        }
    }
 public function edit() {
        // Get POST data safely
        $user_id = $this->input->post('user_id');
        $name = $this->input->post('name', true);
        $username = $this->input->post('username', true);
        $role = $this->input->post('role', true);
        $isActive = $this->input->post('isActive');

        if (!$user_id) {
            $this->session->set_flashdata('error', 'Invalid user ID.');
            redirect('users');
            return;
        }

        // Prepare data array (exclude password update here, do it separately)
        $data = [
            'name' => $name,
            'username' => $username,
            'role' => $role,
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),

            'isActive' => $isActive,
        ];

        // Update user in database
        $this->db->where('user_id', $user_id);
        $updated = $this->db->update('tbl_users', $data);

        if ($updated) {
            $this->session->set_flashdata('success', 'User updated successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to update user.');
        }

        redirect('users');
    }





}

// Controller: Auth.php
