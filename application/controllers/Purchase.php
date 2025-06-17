<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('authModel');
        $this->load->model('productModel'); 
        $this->load->model('salesModel'); // Model to handle sales processing
        $this->load->model('customerModel');
        // Assuming you have a customer model for customer data
        $this->load->model('supplierModel'); // Model to handle supplier data
        $this->load->library('session');
        $this->load->helper(array('url', 'form'));

        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
        
    }

    public function index() {
        $data['products'] = $this->productModel->get_all();
        $data['suppliers'] = $this->supplierModel->get_all(); 
        // Pass $data to the view
        $this->load->view('main', [
            'content_view' => 'dashboard/purchase_content',
            'data' => $data  // Pass data to the content view
        ]);
    }

    public function process_po() {
        $supplier_id = $this->input->post('supplier_id');
        $items_json = $this->input->post('items');
        $items = json_decode($items_json); // JSON array of product_id, quantity, unit_price
        $user_id = $this->session->userdata('user_id');
        $total_amount = $this->input->post('total_amount');
    
        if (!$items || !is_array($items)) {
            // Log the invalid input for debugging
            log_message('error', 'Invalid or empty items JSON: ' . $items_json);
            echo json_encode(['status' => 'error', 'message' => 'Invalid item list.']);
            return;
        }
    
        // Save PO to database
        $po_data = [
            'supplier_id' => $supplier_id,
            'user_id' => $user_id,
            'total_amount' => $total_amount,
            'status' => 'Pending',
            'created_at' => date('Y-m-d H:i:s'),
            'location' => $this->session->userdata('location')
        ];
        $this->db->insert('tbl_purchase_orders', $po_data);
        $po_id = $this->db->insert_id();
    
        foreach ($items as $item) {
            $this->db->insert('tbl_purchase_items', [
                'po_id' => $po_id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'unit_price' => $item->price,
                'subtotal'   => $item->quantity * $item->price
    
            ]);
        }
    
        echo json_encode([
            'message' => 'Purchase Order created successfully.',
            'po_id' => $po_id
        ]);
    }
    

    public function print_po($po_id) {
        $this->load->model('purchaseModel');
        $data['po'] = $this->purchaseModel->get_po_by_id($po_id);
        $data['po_items'] = $this->purchaseModel->get_po_items($po_id);
        $this->load->view('dashboard/purchase/receipt', $data);
    }


}
