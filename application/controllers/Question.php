<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Question extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Question_model');
        $this->load->model('answer_model');
    }
    public function view($question_id) {
        $this->load->model('question_model');
        $this->load->model('answer_model');       
        $data['question'] = $this->question_model->get_question($question_id);        
        $data['answers'] = $this->answer_model->get_answers($question_id);        
        $this->load->view('question_view', $data);
    }
    public function submit_answer($question_id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_id = $this->session->userdata('user_id');
            $data = array(
                'user_id' => $user_id,
                'content' => $this->input->post('answer_content'),
                'question_id' => $question_id,
            );
            $this->answer_model->add_answer($data);
            redirect('question/view/' . $question_id);
        }
    }
    public function upvote_answer($answer_id, $question_id) {
        $this->load->model('question_model');
        //perform upvote logic
        $this->question_model->upvote_answer($answer_id, $question_id);
        redirect('question/view/' . $question_id);
    }
    public function downvote_answer($answer_id, $question_id) {
        $this->load->model('question_model');
        //downvote logic
        $this->question_model->downvote_answer($answer_id, $question_id);
        redirect('question/view/' . $question_id);
    }
}
?>