<?php

defined('BASEPATH') OR exit('No direct script access allowed');
use Restserver\Libraries\REST_Controller;
require(APPPATH . '/libraries/REST_Controller.php');


class Userapi extends REST_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('User_Model', 'um');
    }

   
    // Endpoint not used
    function users_get() {
        $users = $this->um->get_users();

        if ($users) {
            $this->response($users, 200);
        } else {
            $this->response(NULL, 404);
        }
    }

    function login_get(){
        $this->load->view('login');
    }
    function user_post() {
        if (!$this->post('username') || !$this->post('password')) {
            $this->response(NULL, 400);
        } else {
            $username = $this->post('username');
            $password = $this->post('password');
            $salt = ('1ndf341endf13i9f2f3dmvnbc1k4');
            $hashed = hash('sha512',$password.$salt);
            
            $user = $this->um->get_user($username,$hashed);

            if ($user) {
                $this->response($user, 200); // 200 being the HTTP response code
            } else {
                $this->response('Invalid Credentials!', 401); // Not authorized
            }
        }
    }

    function register_post() {
        $username = $this->post('username');
        $password = $this->post('password');
        
        $does_exist = $this->um->is_username_unique($username);

        if($does_exist){
            $this->response('Username already exists!', 401);
        }else {
            $salt = ('1ndf341endf13i9f2f3dmvnbc1k4');
            $hashed = hash('sha512',$password.$salt);
            
            $user = $this->um->add_user($username,$hashed);
            if ($user) {
                $this->response($user, 200); // 200 being the HTTP response code
            } else {
                // Todo show error !
                $this->response('Invalid Credentials!', 401); // Not authorized
            }
        }        
    }

}