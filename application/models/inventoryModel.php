<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class inventoryModel extends CI_Model {

    // Fetch all inventory records
    public function get_all() {
        $this->db->select('i.*, p.barcode, p.category_id, p.unit_id, p.cost_price, p.retail_price, p.description, p.product_name');
        $this->db->from('tbl_inventory i');
        $this->db->join('tbl_products p', 'p.product_id = i.product_id');
        $query = $this->db->get();
        return $query->result();
    }


    // Update stock for a product
    public function update_stock($product_id, $quantity, $type = 'in') {
        // Fetch current stock
        $this->db->where('product_id', $product_id);
        $inventory = $this->db->get('tbl_inventory')->row();

        if ($inventory) {
            if ($type == 'in') {
                $inventory->current_stock += $quantity;
                $inventory->stock_in += $quantity;
            } else {
                $inventory->current_stock -= $quantity;
                $inventory->stock_out += $quantity;
            }

            $this->db->where('product_id', $product_id);
            $this->db->update('tbl_inventory', [
                'current_stock' => $inventory->current_stock,
                'stock_in' => $inventory->stock_in,
                'stock_out' => $inventory->stock_out,
                'last_updated' => date('Y-m-d H:i:s')
            ]);
        } else {
            // If product not found in inventory, create new record
            $this->db->insert('tbl_inventory', [
                'product_id' => $product_id,
                'current_stock' => $type == 'in' ? $quantity : 0,
                'stock_in' => $type == 'in' ? $quantity : 0,
                'stock_out' => $type == 'out' ? $quantity : 0,
                'last_updated' => date('Y-m-d H:i:s')
            ]);
        }
    }

    // Get stock of a specific product
    public function get_stock($product_id) {
        $this->db->where('product_id', $product_id);
        return $this->db->get('tbl_inventory')->row();
    }

    public function get_inventory_report($start_date = null, $end_date = null) {
        $this->db->select('
            p.product_id,
            p.product_name,
            p.description,
            c.category_name,
            u.unit_name,
            SUM(i.stock_in) as total_stock_in,
            SUM(i.stock_out) as total_stock_out,
            MAX(i.current_stock) as current_stock,
            MAX(i.last_updated) as last_updated
        ');
        $this->db->from('tbl_inventory i');
        $this->db->join('tbl_products p', 'p.product_id = i.product_id');
        $this->db->join('tbl_categories c', 'c.category_id = p.category_id', 'left');
        $this->db->join('tbl_units u', 'u.unit_id = p.unit_id', 'left');

        if ($start_date) {
            $this->db->where('i.last_updated >=', $start_date);
        }
        if ($end_date) {
            $this->db->where('i.last_updated <=', $end_date);
        }

        $this->db->group_by('p.product_id');
        $this->db->order_by('p.product_name', 'ASC');

        $query = $this->db->get();
        return $query->result();
    }
}
