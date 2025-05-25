<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class unitModel extends CI_Model {

    public function get_all() {
        return $this->db->get('tbl_units')->result();
    }

    public function insert($data) {
        return $this->db->insert('tbl_units', $data);
    }

    public function get_by_id($id) {
        return $this->db->get_where('tbl_units', ['unit_id' => $id])->row();
    }

    public function update($id, $data) {
        $this->db->where('unit_id', $id);
        return $this->db->update('tbl_units', $data);
    }

    public function delete($id) {
        $this->db->where('unit_id', $id);
        return $this->db->delete('tbl_units');
    }
}
