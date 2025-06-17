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

        if ($this->session->userdata('role') === 'cashier') {
            $this->session->set_flashdata('error', 'You are not allowed to access.');
            redirect('users');
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
            'isActive' => 1
        ];

        $this->userModel->insert($data);
        $insert_id = $this->db->insert_id();

        $this->log_action('Users', $insert_id, 'Created', null, $data, 'New user created');

        $this->session->set_flashdata('success', 'User added successfully.');
        redirect('users');
    }
}

public function edit() {
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

    $old_data = $this->db->get_where('tbl_users', ['user_id' => $user_id])->row_array();

    $data = [
        'name' => $name,
        'username' => $username,
        'role' => $role,
        'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
        'isActive' => $isActive,
    ];

    $this->db->where('user_id', $user_id);
    $updated = $this->db->update('tbl_users', $data);

    if ($updated) {
        $this->log_action('Users', $user_id, 'Updated', $old_data, $data, 'User updated');
        $this->session->set_flashdata('success', 'User updated successfully.');
    } else {
        $this->session->set_flashdata('error', 'Failed to update user.');
    }

    redirect('users');
}

public function delete($id = null) {
    if ($id === null) {
        $this->session->set_flashdata('error', 'Invalid user ID.');
        redirect('users');
        return;
    }

    $old_data = $this->db->get_where('tbl_users', ['user_id' => $id])->row_array();

    if (!$old_data) {
        $this->session->set_flashdata('error', 'User not found.');
        redirect('users');
        return;
    }

    $deleted = $this->userModel->delete($id); // Assumes delete method exists in userModel

    if ($deleted) {
        $this->log_action('Users', $id, 'Deleted', $old_data, null, 'User deleted');
        $this->session->set_flashdata('success', 'User deleted successfully.');
    } else {
        $this->session->set_flashdata('error', 'Failed to delete user.');
    }

    redirect('users');
}




}

// Controller: Auth.php
