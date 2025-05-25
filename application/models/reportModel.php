<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// app/Controllers/Reports.php (CI4) OR application/controllers/Reports.php (CI3)
class Reports extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Sales_model');
    }

    public function salesReport() {
        $data['sales'] = $this->Sales_model->get_sales_report();
        $this->load->view('dashboard/report/salesReport', $data);
    }
}



?>
