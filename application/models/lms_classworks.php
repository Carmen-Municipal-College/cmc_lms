<?php
defined('BASEPATH') or exit('No direct script access allowed');

class lms_classworks extends CI_Model
{

    public function get_classworks()
    {
        $sql =
            "SELECT * FROM classworks
             JOIN classwork_assign
            ";
        $query = $this->db->query($sql);
        if ($query === false) {
            $error = $this->db->error();
            log_message('error', 'Database error: ' . $error['message']);
            return []; // Return an empty array or handle the error as needed
        }
        return $query->result_array();
    }
}
