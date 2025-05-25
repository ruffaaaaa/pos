<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class productModel extends CI_Model {

    public function get_all() {
        $this->db->select('p.*, c.category_name, u.unit_name, u.abbreviation, i.current_stock');
        $this->db->from('tbl_products p');
        $this->db->join('tbl_categories c', 'p.category_id = c.category_id', 'left');
        $this->db->join('tbl_units u', 'p.unit_id = u.unit_id', 'left');

        // Join subquery for latest inventory per product
        $subquery = "(SELECT i1.inventory_id, i1.product_id, i1.current_stock, i1.last_updated
                    FROM tbl_inventory i1
                    INNER JOIN (
                        SELECT product_id, MAX(last_updated) AS max_date
                        FROM tbl_inventory
                        GROUP BY product_id
                    ) i2 ON i1.product_id = i2.product_id AND i1.last_updated = i2.max_date
                    ) i";

        $this->db->join($subquery, 'p.product_id = i.product_id', 'left', false);  // false disables escaping

        return $this->db->get()->result();

    }


    public function insert($data) {
        return $this->db->insert('tbl_products', $data);
    }

    public function get_by_id($id) {
        return $this->db->get_where('tbl_products', ['product_id' => $id])->row();
    }

    public function update($id, $data) {
        $this->db->where('product_id', $id);
        return $this->db->update('tbl_products', $data);
    }

    public function delete($id) {
        $this->db->where('product_id', $id);
        return $this->db->delete('tbl_products');
    }

    public function update_stock($product_id, $quantity_change) {
        $this->db->set('stock_quantity', 'stock_quantity + ' . (int)$quantity_change, FALSE);
        $this->db->where('product_id', $product_id);
        $this->db->update('tbl_products');
    }

        public function count_by_category($category_id) {
        $this->db->where('category_id', $category_id);
        return $this->db->count_all_results('tbl_products');
    }
}
