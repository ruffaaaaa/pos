<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('authModel');
        $this->load->library('session');
        $this->load->helper(array('url', 'form'));

    }
	public function index()
	{
        $this->load->view('auth/login');
	}

	public function login() {
        $this->load->view('auth/login');
    }

    public function login_process() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->authModel->get_user_by_username($username);

        if ($user && password_verify($password, $user->password)) {
            $this->session->set_userdata('user_id', $user->user_id);
            $this->session->set_userdata('username', $user->username);
            $this->session->set_userdata('role', $user->role);

            // Redirect based on role
            if ($user->role == 'cashier') {
                redirect('sales'); // Redirect to Sales page
            } else {
                redirect('dashboard'); // Admin or others go to Dashboard
            }
        } else {
            $this->session->set_flashdata('error', 'Invalid Username or Password');
            redirect('auth/login');
        }
    }



    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}

// Controller: Auth.php
