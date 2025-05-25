<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class supplierModel extends CI_Model {

    public function get_all() {
        return $this->db->get('tbl_suppliers')->result();
    }

    public function insert($data) {
        return $this->db->insert('tbl_suppliers', $data);
    }

    public function get_by_id($id) {
        return $this->db->get_where('tbl_suppliers', ['supplier_id' => $id])->row();
    }

    public function update($id, $data) {
        $this->db->where('supplier_id', $id);
        return $this->db->update('tbl_suppliers', $data);
    }

    public function delete($id) {
        $this->db->where('supplier_id', $id);
        return $this->db->delete('tbl_suppliers');
    }
}
