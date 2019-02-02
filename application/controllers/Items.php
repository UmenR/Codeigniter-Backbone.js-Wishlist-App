<?php

defined('BASEPATH') OR exit('No direct script access allowed');
use Restserver\Libraries\REST_Controller;
require(APPPATH . '/libraries/REST_Controller.php');
require_once(APPPATH . '/libraries/Jwt_Imp.php');


class Items extends REST_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('ItemModel', 'im');
        $this->jwtImp = new Jwt_Imp();
    }

    /**
     * Endpoint Used to send the index page
     */
    function index_get(){
        $this->load->view('Templates/Header');
        $this->load->view('Wishlist');
    }

    /**
     * Endpoint used to add an item to the system
     */
    function item_post() {
        if($this->post('token') && $this->validateToken($this->post('token')) && $this->session->userdata('is_logged_in') ) { 
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
      } else {
        $this->response('Access denied please login!', 401);
      }
    }

    /**
     * Endpoint used to get an item from the system
     */
    function item_get() {
        if($this->session->userdata('is_logged_in')) {
        if($this->get('id')){
            $itemid = $this->get('id');
            $item = $this->im->get_item($itemid);
                if ($item) {
                    $this->response($item, 200); // 200 being the HTTP response code
                } else {
                    $this->response('Ooops! We cant find that item', 404); // Not authorized
                }
        } else {
            $this->response('Bad Request!', 400);
        }
      } else {
        $this->response('Access denied please login!', 401);
      }
    }

    /**
     * Endpoint used to get all items of a user
     */
    function allitems_get() {
        if($this->session->userdata('is_logged_in')) {
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
      } else {
        $this->response('Access denied please login!', 401);
      }
    }

    /**
     * Endpoint used to update an item
     */
    function item_put(){
        if($this->session->userdata('is_logged_in')){
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
      }else {
        $this->response('Access denied please login!', 401);
      }
    }
    /**
     * Endpoint used to delete an item
     */
    function item_delete(){
        $ci =& get_instance();
        $token = $ci->input->get_request_header('Authorization', TRUE);
        if($this->session->userdata('is_logged_in') && $token && $this->validateToken($token)){
        if(!$this->get('id')){
            $this->response('Bad Request!', 400);
        }else{
            $id = $this->get('id');
            $item = $this->im->delete_item($id);
            if ($item) {
                $this->response($token, 200); // 200 being the HTTP response code
            } else {
                $this->response('Ooops! Something went wrong!', 401); // Not authorized
            }
        }
      }else{
        $this->response('Access denied please login!', 401);
      }
    }
    /**
     * Function used to decode the token sent by the user with requests
     * @param token The token sent by the user with a request
     */
    function validateToken($token){
        try{
            $jwtData = $this->jwtImp->DecodeToken($token);
            return true;
        } catch (Exception $e){
            return false;
        }
    }
    }

