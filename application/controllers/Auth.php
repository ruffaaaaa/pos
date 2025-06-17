<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper(array('url', 'form'));
        $this->load->model('authModel');

    }
	public function index()
	{
        if ($this->session->userdata('user_id')) {
            redirect('dashboard');
        }
        $this->load->view('auth/login');
	}

	public function login() {
        if ($this->session->userdata('user_id')) {
            redirect('dashboard');
        }
        $this->load->view('auth/login');
    }

    public function login_process() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->authModel->get_user_by_username($username);

        if ($user) {
            if ($user->isActive != 1) {
                $this->session->set_flashdata('error', 'Your account is inactive. Please contact the administrator.');
                redirect('auth/login');
            }

            if (password_verify($password, $user->password)) {
                // Store initial session data
                $this->session->set_userdata([
                    'user_id' => $user->user_id,
                    'username' => $user->username,
                    'role' => $user->role
                ]);

                // Skip location selection for cashier
                if ($user->role === 'cashier') {
                    redirect('sales');
                } else {
                    redirect('auth/select_location');
                }
            } else {
                $this->session->set_flashdata('error', 'Invalid Username or Password');
                redirect('auth/login');
            }
        } else {
            $this->session->set_flashdata('error', 'Invalid Username or Password');
            redirect('auth/login');
        }
    }

    public function select_location() {
        // Check if user is logged in first
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }

        $this->load->view('auth/select_location'); // Load location selection view
    }


    public function set_location() {
        $location = $this->input->post('location');

        if ($location == 'store' || $location == 'warehouse') {
            // Save selected location in session
            $this->session->set_userdata('location', $location);

            // Redirect based on selected location
            if ($location == 'warehouse') {
                redirect('dashboard'); // e.g., controller/method for warehouse
            } else {
                redirect('dashboard'); // e.g., controller/method for store dashboard
            }

        } else {
            $this->session->set_flashdata('error', 'Please select a valid location.');
            redirect('auth/select_location');
        }
    }
    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}

// Controller: Auth.php
