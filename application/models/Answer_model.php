<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Answer_model extends CI_Model {
    public function add_answer($data) {
        //assuming there is an 'answers' table
        $this->db->insert('answers', $data);
    }
    public function get_answers($question_id) {
        return $this->db->get_where('answers', ['question_id' => $question_id])->result_array();
    }
}