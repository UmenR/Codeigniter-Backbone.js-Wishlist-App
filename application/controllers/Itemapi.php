<?php

defined('BASEPATH') OR exit('No direct script access allowed');
use Restserver\Libraries\REST_Controller;
require(APPPATH . '/libraries/REST_Controller.php');


class Itemapi extends REST_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('Item_Model', 'im');
    }

    function index_get(){
        // Remember to only send if logged in!
        $this->load->view('todolist');
    }

    function item_post() {
        if (!$this->post('title') || !$this->post('price')||!$this->post('priority')||!$this->post('url')
            ||!$this->post('userid')) {
            $this->response('Bad Request !', 400);
        } else {
            $title = $this->post('title');
            $priority = $this->post('priority');
            $price = $this->post('price');
            $url = $this->post('url');
            $userid = $this->post('userid');

            $item = $this->im->add_item($title,$url,$price,$priority,$userid);

            if ($item) {
                $this->response($item, 200); // 200 being the HTTP response code
            } else {
                $this->response('Ooops! Something went wrong!', 401); // Not authorized
            }
        }
    }

    function item_get() {
        if($this->get('id')){
            $itemid = $this->get('id');
            $item = $this->im->get_item($itemid);
                if ($item) {
                    $this->response($item, 200); // 200 being the HTTP response code
                } else {
                    // Todo show error !
                    $this->response('Ooops! We cant find that item', 404); // Not authorized
                }
        } else {
            $this->response('Bad Request!', 400);
        }
    }

    function items_get() {
        if($this->get('userid')){
            $userid = $this->get('userid');
            $items = $this->im->get_items($userid);
                if ($items) {
                    $this->response($items, 200); // 200 being the HTTP response code
                } else {
                    // Todo show error !
                    $this->response('Ooops! We cant find that item', 404); // Not authorized
                }
        } else {
            $this->response('Bad Request!', 400);
        }
    }
        
    function item_put(){
        if (!$this->put('title') || !$this->put('price')||!$this->put('priority')||!$this->put('url')||
        !$this->get('id')) {
            $this->response('Bad Request!', 400);
        } else {
            $title = $this->put('title');
            $priority = $this->put('priority');
            $price = $this->put('price');
            $url = $this->put('url');
            $id = $this->get('id');

            $item = $this->im->update_item($id,$title,$url,$price,$priority);

            if ($item) {
                $this->response($item, 200); // 200 being the HTTP response code
            } else {
                $this->response('Ooops! Something went wrong!', 401); // Not authorized
            }
        }
    }

    function item_delete(){
        if(!$this->get('id')){
            $this->response('Bad Request!', 400);
        }else{
            $id = $this->get('id');
            $item = $this->im->delete_item($id);
            if ($item) {
                $this->response($item, 200); // 200 being the HTTP response code
            } else {
                $this->response('Ooops! Something went wrong!', 401); // Not authorized
            }
        }
    }
    }

