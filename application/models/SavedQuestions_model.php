<?php
class SavedQuestions_model extends CI_Model {
    public function save_question($user_id, $question_id) {
        $data = array(
            'user_id' => $user_id,
            'question_id' => $question_id
        );
        $this->db->insert('saved_questions', $data);
    }
    public function is_question_saved($user_id, $question_id) {
        $this->db->where('user_id', $user_id); 
        $this->db->where('question_id', $question_id);
        $query = $this->db->get('saved_questions');
        return $query->num_rows() > 0;
    }
    public function get_saved_questions($user_id) {
        $this->db->select('questions.*');
        $this->db->from('questions');
        $this->db->join('saved_questions', 'questions.question_id = saved_questions.question_id');
        $this->db->where('saved_questions.user_id', $user_id);

        $query = $this->db->get();
        return $query->result_array();
    }
}
?>