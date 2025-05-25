<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH . 'vendor/autoload.php';


class Report extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('authModel');
        $this->load->model('supplierModel'); 
        $this->load->model('inventoryModel');
        $this->load->model('customerModel');
        $this->load->model('categoryModel');
        $this->load->model('productModel');
        $this->load->model('salesModel'); 
        $this->load->model('unitModel');
        $this->load->library(array('session', 'upload'));
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
        $report = $this->input->get('report');
        $export = $this->input->get('export');

        $start_date_raw = $this->input->get('start_date');
        $end_date_raw = $this->input->get('end_date');
        $start_date = $start_date_raw ? $start_date_raw . ' 00:00:00' : null;
        $end_date = $end_date_raw ? $end_date_raw . ' 23:59:59' : null;

        if ($report == 'sales') {
            $this->load->model('salesModel');
            $sales = $this->salesModel->get_sales_with_profit($start_date, $end_date);

            if ($export == 'csv') {
                $this->export_sales_csv($sales);
                return; // stop further processing
            }

            $data['sales'] = $sales;

        } elseif ($report == 'inventory') {
            $this->load->model('InventoryModel');
            $inventory = $this->InventoryModel->get_inventory_report($start_date, $end_date);

            if ($export == 'csv') {
                $this->export_inventory_csv($inventory);
                return; // stop further processing
            }

            $data['inventory'] = $inventory;
        }

        $data['report'] = $report;
        $data['start_date'] = $start_date_raw; // for form input display
        $data['end_date'] = $end_date_raw;
        $data['content_view'] = 'dashboard/report_content';

        $this->load->view('main', $data);
    }

    private function export_sales_csv($sales) {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="sales_report_' . date('Ymd') . '.csv"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $output = fopen('php://output', 'w');

        // CSV Header row
        fputcsv($output, ['Date', 'Sale ID', 'Product', 'Sold to', 'Qty', 'Cost Price', 'Unit Price', 'Total Cost', 'Total Revenue', 'Profit']);

        foreach ($sales as $row) {
            fputcsv($output, [
                date('Y-m-d', strtotime($row->created_at)),
                $row->sale_id,
                $row->product_name,
                $row->customer_name,
                $row->quantity,
                number_format($row->cost_price, 2),
                number_format($row->unit_price, 2),
                number_format($row->total_cost, 2),
                number_format($row->total_revenue, 2),
                number_format($row->profit, 2)
            ]);
        }

        fclose($output);
    }

    private function export_inventory_csv($inventory) {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="inventory_report_' . date('Ymd') . '.csv"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $output = fopen('php://output', 'w');

        // CSV Header row
        fputcsv($output, ['Product', 'Category', 'Unit', 'Total Stock In', 'Total Stock Out', 'Current Stock', 'Last Updated']);

        foreach ($inventory as $item) {
            fputcsv($output, [
                $item->product_name,
                $item->category_name,
                $item->unit_name,
                $item->total_stock_in,
                $item->total_stock_out,
                $item->current_stock,
                date('Y-m-d', strtotime($item->last_updated))
            ]);
        }

        fclose($output);
    }





}

// Controller: Auth.php
