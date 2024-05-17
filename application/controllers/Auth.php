<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('url'); 
        $this->load->model('user_model');
        $this->load->database(); 
        $this->load->library('form_validation'); 
        $this->load->library('session'); 
    }
    public function register() {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');
        //check if form validation passes
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('register');
        } else {
            //prepare data for registration
            $data = array(
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT)
            );
            $this->user_model->register($data);
            redirect('auth/login');
        }
    }
    public function login() {
        $this->load->view('login');
    }
    public function logout() {
        $this->session->unset_userdata('user_id');
        redirect('auth/login');
    }
}
?>
