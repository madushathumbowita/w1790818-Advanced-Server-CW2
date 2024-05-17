<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url'); 
        $this->load->model('User_model'); 
        $this->load->library('form_validation'); 
        $this->load->library('session'); 
    }
    public function index() {
        $user_id = $this->session->userdata('user_id');
        if (!$user_id) {
            //user is not logged in
            redirect('auth/login');
            return; 
        }
        //retrieve user data
        $data['user'] = $this->User_model->get_user($user_id);
        $this->load->view('profile_view', $data);
    }
    public function updateUsernameEmail() {
        //check if the form is submitted
        if ($this->input->post()) {
            $user_id = $this->session->userdata('user_id');
            if ($user_id) {
                $this->load->library('form_validation');   
                //form validation rules for username and email
                $this->form_validation->set_rules('username', 'Username', 'required');
                $this->form_validation->set_rules('email', 'Email', 'required|valid_email');   
                if ($this->form_validation->run() == FALSE) {
                    //form validation failed, reload profile page with validation errors
                    $this->index();
                } else {
                    //prepare data to update
                    $data = array(
                        'username' => $this->input->post('username'),
                        'email' => $this->input->post('email')
                    );                    
                    log_message('debug', 'Data array to update username and email: ' . print_r($data, true));    
                    $this->User_model->update_user_name($user_id, $data);   
                    redirect('profile');
                }
            } else {
                //when user is not logged in
                redirect('auth/login');
            }
        } else {
            //when form is not submitted
            redirect('profile');
        }
    }
    public function updatePassword() {
        //check if the form is submitted
        if ($this->input->post()) {
            $user_id = $this->session->userdata('user_id');
            if ($user_id) {
                //manual password validation
                if (empty($this->input->post('password')) || empty($this->input->post('confirm_password'))) {
                    echo "Password fields are required.";
                    return;
                } elseif ($this->input->post('password') != $this->input->post('confirm_password')) {
                    echo "Passwords do not match.";
                    return;
                }   
                $data = array(
                    'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT)
                );                
                log_message('debug', 'Data array to update password: ' . print_r($data, true));    
                //update password
                $this->User_model->update_user_password($user_id, $data['password']);    
                redirect('profile');
            } else {
                //when user is not logged in
                redirect('auth/login');
            }
        } else {
            //when form is not submitted
            redirect('profile');
        }
    }
    public function logout() {
        //clear user session data
        $this->session->unset_userdata('user_id');
        redirect('dashboard');
    }
}
?>
