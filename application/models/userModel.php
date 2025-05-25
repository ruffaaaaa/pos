<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class userModel extends CI_Model {

    public function get_all() {
        return $this->db->get('tbl_users')->result();
    }

    public function insert($data) {
        return $this->db->insert('tbl_users', $data);
    }

    public function get_by_id($id) {
        return $this->db->get_where('tbl_users', ['user_id' => $id])->row();
    }

    public function update($id, $data) {
        $this->db->where('user_id', $id);
        return $this->db->update('tbl_users', $data);
    }

    public function delete($id) {
        $this->db->where('user_id', $id);
        return $this->db->delete('tbl_users');
    }
}
