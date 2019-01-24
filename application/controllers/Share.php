<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use Restserver\Libraries\REST_Controller;
require(APPPATH . '/libraries/REST_Controller.php');


class Share extends REST_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('User_Model', 'um');
        $this->load->model('Item_Model', 'im');
    }

    function list_get() {
        if($this->get('id')){
            $userid = $this->get('id');
            $user = $this->um->get_details($userid);
                if ($user) {
                    $result;
                    if($user->listcreated == 1){
                        $result = $this->im->get_items($userid);
                        $result['items'] = $result;
                        
                    } else {
                        $result = NULL;
                    }
                    $result['userdata'] = $user;
                    $this->load->view('share', $result); 
                } else {
                    // Todo show error !
                    $this->response('Ooops! We cant find that user please request for another link', 404); // Not authorized
                }
        } else {
            $this->response('Bad Request!', 400);
        }
    }

    
}