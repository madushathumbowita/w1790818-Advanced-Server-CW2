<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/RestController.php';
require APPPATH . 'libraries/Format.php';

use chriskacerguis\RestServer\RestController; //import the rest controller namespace
class AuthRequest extends RestController {
    function __construct() {
        parent::__construct();
        $this->load->model('user_model'); //for database interactions
        $this->load->library('form_validation'); //for input validation
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->database();
    }
    public function login_post() {
        //get username and password from the POST request
        $username = $this->post('username');
        $password = $this->post('password');
        $this->form_validation->set_data(['username' => $username, 'password' => $password]);
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->response([
                'status' => FALSE,
                'message' => 'Login failed. Validation errors.',
                'errors' => $this->form_validation->error_array()
            ], RestController::HTTP_BAD_REQUEST);
         } else {
            $user = $this->user_model->login($username, $password);
            if ($user) {
                //set session with user_id
                $this->session->set_userdata('user_id', $user->user_id);
                $this->response([
                    'status' => TRUE,
                    'message' => 'Login successful',
                    'userData' => $user
                ], RestController::HTTP_OK);
            } else {
                $this->response([
                    'status' => FALSE,
                    'message' => 'Login failed. Email or Password incorrect.'
                ], RestController::HTTP_BAD_REQUEST);
            }
        }
    }
}
?>