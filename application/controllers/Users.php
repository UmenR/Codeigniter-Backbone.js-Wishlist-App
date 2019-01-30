<?php

defined('BASEPATH') OR exit('No direct script access allowed');
use Restserver\Libraries\REST_Controller;
require(APPPATH . '/libraries/REST_Controller.php');
require_once(APPPATH . '/libraries/Jwt_Imp.php');


class Users extends REST_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('User_Model', 'um');
        $this->jwtImp = new Jwt_Imp();
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

    /**
     * Endpoint used to update user data
     */
    function user_put(){
        if($this->session->userdata('is_logged_in') == true) {
            if (!$this->put('listtitle') || !$this->put('listdescription') || !$this->get('id')) {
                $this->response(NULL, 400);
            } else {
                $id = $this->get('id');
                $title = $this->put('listtitle');
                $description = $this->put('listdescription');
                $user = $this->um->update_user($id,$title,$description);
    
                if ($user) {
                    $this->response($user, 200); // 200 being the HTTP response code
                } else {
                    $this->response('Invalid Credentials!', 401); // Not authorized
                }
            }
        } else {
            $this->response('Please Login', 401);
        }
    }

    /**
     * Endpoint used to get the login page
     */
    function login_get(){
        $this->load->view('Templates/Header');
        $this->load->view('Login');
    }

    /**
     * Endpoint used to get the register page
     */
    function register_get(){
        $this->load->view('Templates/Header');
        $this->load->view('Register');
    }

    /**
     * Endpoint used to logout a user
     * and re send the Login page
     */
    function logout_get(){
        $this->session->sess_destroy();
        $this->load->view('Templates/Header');
        $this->load->view('Login');
    }

    /**
     * Endpoint used to Register user to the system OR
     * Login a user using credentials.
     */
    function user_post() {
        if($this->get('actiontype') == 'login') {
            if (!$this->post('username') || !$this->post('password')) {
                $this->response(NULL, 400);
            } else {
                $username = $this->post('username');
                $password = $this->post('password');
                $salt = ('1ndf341endf13i9f2f3dmvnbc1k4');
                $hashed = hash('sha512',$password.$salt);
                
                $user = $this->um->get_user($username,$hashed);
    
                if ($user) {
                    $sessiondata = array(
                        'username' => $user->username,
                        'id' => $user->id,
                        'is_logged_in' => 'true'
                    );
                    $tokenData['id'] = $user->id;
                    $tokenData['username'] = $user->username;
                    $token = $this->jwtImp->GenerateToken($tokenData);

                    $returnData = array("user"=>$user,"token" =>$token);

                    $this->session->set_userdata($sessiondata);
                    $this->response($returnData, 200); // 200 being the HTTP response code
                    // $this->response($user, 200);
                } else {
                    $this->response('Invalid Credentials!', 401); // Not authorized
                }
            }
        } else if($this->get('actiontype') == 'register') {
                $username = $this->post('username');
                $password = $this->post('password');
                $listtitle = NULL;
                $listDescription = NULL;

                if($this->post('listtitle') && $this->post('listdescription')){
                    $listtitle = $this->post('listtitle');
                    $listDescription = $this->post('listdescription');
                }

                $salt = ('1ndf341endf13i9f2f3dmvnbc1k4');
                $hashed = hash('sha512',$password.$salt);
                $user = $this->um->add_user($username,$hashed,$listtitle,$listDescription);
                    
                if ($user) {
                    $this->response($user, 200); // 200 being the HTTP response code
                } else {
                        // Todo show error !
                    $this->response('Invalid Credentials!', 401); // Not authorized
                } 
        }
    }

}