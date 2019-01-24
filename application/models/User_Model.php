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
        $this->db->select('username, listcreated, listtitle, listdescription,id');
        $query = $this->db->get_where($this->user, array("username" => $username,"password" => $password));
        if ($query) {
            return $query->row();
        }
        return NULL;
    }

    function add_user($username,$password,$listtitle,$listdescription) {
        if($listtitle && $listdescription){
            $query = $this->db->insert($this->user, array("username" => $username,"password" => $password,
            "listtitle" => $listtitle, "listdescription" =>$listdescription,"listcreated"=>1));    
        } else {
            $query = $this->db->insert($this->user, array("username" => $username,"password" => $password,
            "listtitle" => "", "listdescription" =>"","listcreated"=>0));
        }
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            return $insert_id;
        }
        return NULL;
    }

    function update_user($id,$title,$description){
        $data = array("listtitle" => $title,"listdescription" => $description,
         "listcreated" => "1");
        $query = $this->db->update($this->user,$data,"id =".$id);
        if ($query) {
            return $query;
        }
        return NULL;
    }

    function get_details($id){
        $this->db->select('username, listcreated, listtitle, listdescription');
        $query = $this->db->get_where($this->user, array("id" => $id));
        if ($query) {
            return $query->row();
        }
        return NULL;
    }

}