<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PurchaseModel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Get Purchase Order details by ID
     */
    public function get_po_by_id($po_id) {
        $this->db->select('po.*, s.supplier_name, u.username');
        $this->db->from('tbl_purchase_orders po');
        $this->db->join('tbl_suppliers s', 's.supplier_id = po.supplier_id', 'left');
        $this->db->join('tbl_users u', 'u.user_id = po.user_id', 'left');
        $this->db->where('po.po_id', $po_id);
        $query = $this->db->get();

        return $query->row(); // Return a single row object
    }

    /**
     * Get Purchase Order Items by PO ID
     */
    public function get_po_items($po_id) {
        $this->db->select('pi.*, p.product_name, p.barcode');
        $this->db->from('tbl_purchase_items pi');
        $this->db->join('tbl_products p', 'p.product_id = pi.product_id', 'left');
        $this->db->where('pi.po_id', $po_id);
        $query = $this->db->get();

        return $query->result(); // Return an array of items
    }
}
