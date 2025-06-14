<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Documentation extends CI_Controller {

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
            $this->session->set_flashdata('error', 'You are not allowed to access the dashboard.');
            redirect('pos');
        }
    }

    public function index() {
        $this->load->view('documentation/index');
    }

    // ✅ NEW METHOD for loading documentation pages dynamically
    public function pages($page = 'introduction') {
        $view_path = 'documentation/pages/' . $page;

        if (!file_exists(APPPATH . 'views/' . $view_path . '.php')) {
            show_404(); 
        }

        $this->load->view($view_path);
    }
}
