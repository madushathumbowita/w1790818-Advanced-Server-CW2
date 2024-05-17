<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Question_model');
        $this->load->database();
        $this->load->helper('url'); //load URL helper
        $this->load->library('session'); //load URL helper
    }
    public function index() {
        //get top 15 questions from the database
        $data['questions'] = $this->Question_model->get_top_questions(15);
        //load the dashboard view
        $this->load->view('dashboard', $data);
    }
    public function search() {
        $keyword = $this->input->post('keyword'); //assuming the keyword is sent via POST
        if (!empty($keyword)) {
            $data['questions'] = $this->Question_model->search_questions($keyword);
        } else {
            //if keyword is empty, show all questions
            $data['questions'] = $this->Question_model->get_top_questions(15);
        }
        $this->load->view('dashboard', $data);
    }
    public function add_question() {
        $this->load->view('add_question');
    }
    public function save_question() {
        $user_id = $this->session->userdata('user_id');
        $data = array(
            'user_id' => $user_id,
            'title' => $this->input->post('title'),
            'content' => $this->input->post('content'),
            'tags' => $this->input->post('tags'),
            'created_at' => date('Y-m-d H:i:s')
        );
        //add question to the database
        $this->Question_model->add_question($data);    
        redirect('dashboard');
    }
}
?>