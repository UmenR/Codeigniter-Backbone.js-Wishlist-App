<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_Model extends CI_Model {

    private $user = 'User';

    function get_users() {
        $query = $this->db->get($this->user);
        if ($query) {
            return $query->result();
        }
        return NULL;
    }

    function is_username_unique($username){
        $query = $this->db->get_where($this->user, array("username" => $username));
        if($query->num_rows() > 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    function get_user($username,$password) {
        $query = $this->db->get_where($this->user, array("username" => $username,"password" => $password));
        if ($query) {
            return $query->row();
        }
        return NULL;
    }

    function add_user($username,$password) {
        $query = $this->db->insert($this->user, array("username" => $username,"password" => $password));
        if ($query) {
            return $query;
        }
        return NULL;
    }

}