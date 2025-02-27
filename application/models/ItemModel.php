<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ItemModel extends CI_Model {

    private $Item = 'Item';

    function get_items($userid) {
        $query = $this->db->get_where($this->Item, array("userid" => $userid));
        if ($query) {
            return $query->result();
        }
        return NULL;
    }

    function get_item($itemid) {
        $query = $this->db->get_where($this->Item, array("id" => $itemid));
        if ($query) {
            return $query->row();
        }
        return NULL;
    }

    function add_item($title,$url,$price,$priority,$userid) {
        $query = $this->db->insert($this->Item, 
        array("title" => $title,"url" => $url, "price" => $price, "priority" => $priority, "userid"=> $userid));
        $insert_id = $this->db->insert_id();
        if ($insert_id) {
            $return_data = array('id' => $insert_id);
            return $return_data;
        }
        return NULL;
    }

    function update_item($id,$title,$url,$price,$priority) {
        $data = array("title" => $title,"url" => $url, "price" => $price, "priority" => $priority);
        $query = $this->db->update($this->Item,$data,"id =".$id);
        if ($query) {
            return $query;
        }
        return NULL;
    }

    function delete_item($id){
        $query = $this->db->delete($this->Item,array('id'=>$id));
        if ($query) {
            return $query;
        }
        return NULL;
    }

}