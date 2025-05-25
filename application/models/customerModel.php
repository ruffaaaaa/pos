<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class customerModel extends CI_Model {

    public function get_all() {
        return $this->db->get('tbl_customers')->result();
    }

    public function insert($data) {
        return $this->db->insert('tbl_customers', $data);
    }

    public function get_by_id($id) {
        return $this->db->get_where('tbl_customers', ['customer_id' => $id])->row();
    }

    public function update($id, $data) {
        $this->db->where('customer_id', $id);
        return $this->db->update('tbl_customers', $data);
    }

    public function delete($id) {
        $this->db->where('customer_id', $id);
        return $this->db->delete('tbl_customers');
    }
}
