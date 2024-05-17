<?php
class SavedQuestions extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('SavedQuestions_model');
        $this->load->model('Question_model');
        $this->load->database();
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('user_agent');
    }
    public function get_answers($question_id) {
        //fetch answers for the given question id
        $this->db->select('*');
        $this->db->from('answers');
        $this->db->where('question_id', $question_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function save($question_id) {
        $user_id = $this->session->userdata('user_id');
        $this->load->model('Question_model');   
        if (!$user_id) {
            //user is not logged in
            $data['message'] = 'Please log in or sign up to save the question.';
        } else {
            //check if the question is already saved
            if ($this->SavedQuestions_model->is_question_saved($user_id, $question_id)) {
                $data['message'] = 'QUESTION IS ALREADY SAVED.';
            } else {
                //save the question
                $this->SavedQuestions_model->save_question($user_id, $question_id);
                $data['message'] = 'QUESTION SAVED.';
            }            
        $data['question'] = $this->Question_model->get_question($question_id);
        if ($data['question']) {
            $data['answers'] = $this->Question_model->get_answers($question_id);
            $this->load->view('question_view', $data);
        } else {
            $data['message'] = 'Question not found.';
            $this->load->view('question_view', $data);
        }
    }
}
    //view all saved questions
    public function index() {
        $user_id = $this->session->userdata('user_id');
        $data['saved_questions'] = $this->SavedQuestions_model->get_saved_questions($user_id);
        //load view and pass data
        $this->load->view('saved_questions', $data);
    }
}
?>