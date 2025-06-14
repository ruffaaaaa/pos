<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class salesModel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Save the sale record into tbl_sales
    public function save_sale($total, $payment_type, $user_id) {
        $sale_data = [
            'user_id' => $user_id,
            'total_amount' => $total,
            'payment_type' => $payment_type
        ];
        $this->db->insert('tbl_sales', $sale_data);
        return $this->db->insert_id();  // Return the sale_id
    }

    // Save the sale items into tbl_sale_items
    public function save_sale_items($sale_id, $cart) {
        foreach ($cart as $item) {
            $sale_item_data = [
                'sale_id' => $sale_id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'unit_price' => $item->retail_price,
                'subtotal' => $item->retail_price * $item->quantity
            ];
            $this->db->insert('tbl_sale_items', $sale_item_data);
        }
    }

    // Save the payment transaction into tbl_transactions
    public function save_transaction($sale_id, $payment_amount, $payment_method) {
        $transaction_data = [
            'sale_id' => $sale_id,
            'payment_amount' => $payment_amount,
            'payment_method' => $payment_method
        ];
        $this->db->insert('tbl_transactions', $transaction_data);
    }
    
    public function get_sale_by_id($sale_id) {
        return $this->db->select('s.*, t.payment_amount, c.customer_name')
            ->from('tbl_sales s')
            ->join('tbl_transactions t', 't.sale_id = s.sale_id', 'left')
            ->join('tbl_customers c', 'c.customer_id = s.customer_id', 'left')
            ->where('s.sale_id', $sale_id)
            ->get()
            ->row();
    }

    public function get_sale_items($sale_id) {
        return $this->db->select('si.*, p.product_name')
            ->from('tbl_sale_items si')
            ->join('tbl_products p', 'p.product_id = si.product_id', 'left')
            ->where('si.sale_id', $sale_id)
            ->get()
            ->result();
    }

    public function get_sales_with_profit($start_date = null, $end_date = null) {
        $this->db->select('
            si.sale_id,
            s.created_at,
            p.product_name,
            si.quantity,
            p.cost_price,
            si.unit_price,
            (si.quantity * p.cost_price) as total_cost,
            (si.quantity * si.unit_price) as total_revenue,
            ((si.quantity * si.unit_price) - (si.quantity * p.cost_price)) as profit, 
            c.customer_name
        ');
        $this->db->from('tbl_sale_items si');
        $this->db->join('tbl_sales s', 'si.sale_id = s.sale_id');
        $this->db->join('tbl_products p', 'si.product_id = p.product_id');
        $this->db->join('tbl_customers c', 's.customer_id = c.customer_id', 'left');

        if ($start_date && $end_date) {
            $this->db->where('DATE(s.created_at) >=', $start_date);
            $this->db->where('DATE(s.created_at) <=', $end_date);
        }

        $query = $this->db->get();
        return $query->result();
    }

    public function get_all_sales($start_date = null, $end_date = null)
    {
        $this->db->select('s.*, c.customer_name, si.product_id, si.quantity, si.unit_price, si.subtotal')
            ->from('tbl_sales s')
            ->join('tbl_customers c', 'c.customer_id = s.customer_id', 'left')
            ->join('tbl_sale_items si', 'si.sale_id = s.sale_id', 'left');

        // Apply date filter if both start and end dates are provided
        if ($start_date && $end_date) {
            $this->db->where('DATE(s.created_at) >=', $start_date);
            $this->db->where('DATE(s.created_at) <=', $end_date);
        }

        $this->db->order_by('s.created_at', 'DESC');

        return $this->db->get()->result();
    }


}


?>
