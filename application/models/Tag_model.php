<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tag_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
    }
    public function get_all_tags() {
        $this->db->select('*');
        $this->db->from('tags');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_questions_by_tag($tag_id) {
        $this->db->select('questions.*');
        $this->db->from('questions');
        $this->db->join('question_tags', 'question_tags.question_id = questions.question_id');
        $this->db->where('question_tags.tag_id', $tag_id);
        $query = $this->db->get();
        return $query->result_array();
    }
}
?>