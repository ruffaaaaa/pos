<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('authModel');
        $this->load->model('dashboardModel');
        $this->load->library('session');
        $this->load->helper(array('url', 'form', 'php_currency'));

        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }

         if ($this->session->userdata('role') === 'cashier') {
        $this->session->set_flashdata('error', 'You are not allowed to access the dashboard.');
        redirect('pos'); // or any other page for cashiers
    }
    }

    public function index() {
        $data['item'] = $this->dashboardModel->getItemCount();
        $data['supplier'] = $this->dashboardModel->getSupplierCount();
        $data['customer'] = $this->dashboardModel->getCustomerCount();
        $data['user'] = $this->dashboardModel->getUserCount();
        $data['product'] = $this->dashboardModel->getProductsInDemand();

        // ✅ You can also pass username and role to the view
        $data['username'] = $this->session->userdata('username');
        $data['role'] = $this->session->userdata('role');

        $this->load->view('main', $data);
    }
}
