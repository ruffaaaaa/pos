<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logs extends CI_Controller {

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

         if ($this->session->userdata('role') === 'cashier') {
        $this->session->set_flashdata('error', 'You are not allowed to access the dashboard.');
        redirect('pos'); // or any other page for cashiers
    }
    }

    public function index() {
        $this->load->model('logsModel');
        $data['logs'] = $this->logsModel->get_all_logs();


        $this->load->view('main', [
            'content_view' => 'dashboard/logs_content',
            'logs' => $data['logs'], // pass sales directly
        ]);
    }

}

// Controller: Auth.php
