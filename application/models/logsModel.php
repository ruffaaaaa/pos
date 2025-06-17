<?php
class logsModel extends CI_Model
{
    public function get_all_logs()
    {
        return $this->db
            ->select('l.*, u.name AS user_name')
            ->from('tbl_logs l')
            ->join('tbl_users u', 'u.user_id = l.user_id', 'left')
            ->where('l.location', $this->session->userdata('location'))
            ->order_by('l.created_at', 'DESC')
            ->get()
            ->result();
    }
}
