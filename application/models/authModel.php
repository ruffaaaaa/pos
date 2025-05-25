<?php

class authModel extends CI_Model {
    public function check_login($username, $password) {
        $this->db->where('username', $username);
        $this->db->where('password', $password);
        $query = $this->db->get('tbl_users');

        if ($query->num_rows() == 1) {
            return $query->row();
        }
        return false;
    }

    public function get_user_by_username($username) {
    return $this->db->where('username', $username)->get('tbl_users')->row();
}

}