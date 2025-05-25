<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sales extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('authModel');
        $this->load->model('productModel'); 
        $this->load->model('salesModel'); // Model to handle sales processing
        $this->load->model('customerModel'); // Assuming you have a customer model for customer data
        $this->load->library('session');
        $this->load->helper(array('url', 'form'));

        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
    }

    public function index() {
        $data['products'] = $this->productModel->get_all();
        $data['customers'] = $this->customerModel->get_all(); 
        // Pass $data to the view
        $this->load->view('main', [
            'content_view' => 'dashboard/sales_content',
            'data' => $data  // Pass data to the content view
        ]);
    }

public function process() {
    $cart = json_decode($this->input->post('cart'));
    $total = $this->input->post('total');
    $discount = $this->input->post('discount');
    $customerId = $this->input->post('customer_id');
    $cashAmount = $this->input->post('cash_amount');
    $paymentType = 'cash';

    $this->db->trans_begin(); // Start transaction

    $user_id = $this->session->userdata('user_id');
    if (empty($user_id)) {
        echo json_encode(['message' => 'User not logged in or user_id not set']);
        return;
    }

    // Save sale
    $sale_data = [
        'user_id' => $user_id,
        'total_amount' => $total,
        'discount' => $discount,
        'customer_id' => $customerId,
        'final_amount' => $total - $discount,
        'payment_type' => $paymentType,
        'created_at' => date('Y-m-d H:i:s')
    ];
    $this->db->insert('tbl_sales', $sale_data);
    $sale_id = $this->db->insert_id();

    foreach ($cart as $item) {
        $sale_item = [
            'sale_id' => $sale_id,
            'product_id' => $item->product_id,
            'quantity' => $item->quantity,
            'unit_price' => $item->price,
            'subtotal' => $item->price * $item->quantity
        ];
        $this->db->insert('tbl_sale_items', $sale_item);

        // Update stock
        $this->db->set('current_stock', 'current_stock - ' . $item->quantity, false);
        $this->db->where('product_id', $item->product_id);
        $this->db->update('tbl_inventory');

        // Optional: Check if affected_rows() is 0 (means update failed)
        if ($this->db->affected_rows() === 0) {
            $this->db->trans_rollback();
            echo json_encode(['message' => 'Failed to update stock for product ID ' . $item->product_id]);
            return;
        }
    }

    $transaction_data = [
        'sale_id' => $sale_id,
        'payment_amount' => $cashAmount,
        'payment_method' => $paymentType
    ];
    $this->db->insert('tbl_transactions', $transaction_data);

    if ($this->db->trans_status() === FALSE) {
        $this->db->trans_rollback();
        echo json_encode(['message' => 'Transaction failed, please try again.']);
    } else {
        $this->db->trans_commit();
        echo json_encode([
            'message' => 'Transaction completed successfully.',
            'sale_id' => $sale_id
        ]);
    }
}



public function receipt($sale_id) {
    // Load necessary models
    $this->load->model('salesModel');
    
    
    // Get sale details by sale_id
    $data['sale'] = $this->salesModel->get_sale_by_id($sale_id);
    $data['sale_items'] = $this->salesModel->get_sale_items($sale_id);

    // Load receipt view
    $this->load->view('dashboard/sales/receipt', $data);
}


}
