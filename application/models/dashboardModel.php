<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class dashboardModel extends CI_Model {

    public function getItemCount() {
        return $this->db->get('tbl_products')->result(); // count($result) in view
    }

    public function getSupplierCount() {
        return $this->db->get('tbl_suppliers')->result();
    }

    public function getCustomerCount() {
        return $this->db->get('tbl_customers')->result();
    }

    public function getUserCount() {
        return $this->db->get('tbl_users')->result();
    }

    public function getProductsInDemand() {
    $this->db->select('p.*, 
        SUM(CASE WHEN si.created_at BETWEEN DATE_SUB(NOW(), INTERVAL 6 DAY) AND NOW() THEN si.quantity ELSE 0 END) as qty,
        SUM(CASE WHEN si.created_at BETWEEN DATE_SUB(NOW(), INTERVAL 13 DAY) AND DATE_SUB(NOW(), INTERVAL 7 DAY) THEN si.quantity ELSE 0 END) as prev_qty');

        $this->db->from('tbl_products p');
        $this->db->join('tbl_sale_items si', 'si.product_id = p.product_id');
        $this->db->group_by('si.product_id');
        $this->db->order_by('qty', 'DESC');
        return $this->db->get()->result();
    }

}
