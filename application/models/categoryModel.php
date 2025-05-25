<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class categoryModel extends CI_Model {

    public function get_all() {
        return $this->db->get('tbl_categories')->result();
    }

    public function insert($data) {
        return $this->db->insert('tbl_categories', $data);
    }

    public function get_by_id($id) {
        return $this->db->get_where('tbl_categories', ['category_id' => $id])->row();
    }

    public function update($id, $data) {
        $this->db->where('category_id', $id);
        return $this->db->update('tbl_categories', $data);
    }

    public function delete($id) {
        $this->db->where('category_id', $id);
        return $this->db->delete('tbl_categories');
    }
}
