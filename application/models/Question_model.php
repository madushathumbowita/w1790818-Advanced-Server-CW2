<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Question_model extends CI_Model {
    public function get_top_questions($limit) {
        //fetch top questions
        $this->db->select('*');
        $this->db->from('questions');
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function add_question($data) {
        //extract tags from the data array
        $tags = explode(',', $data['tags']);
        unset($data['tags']); //remove tags from the $data array
        //insert question into the database
        $this->db->insert('questions', $data);
        $question_id = $this->db->insert_id(); 
        //insert tags into the tags table if they don't exist already
        foreach ($tags as $tag) {
            $tag = trim($tag);
            $tag_exists = $this->db->get_where('tags', array('tag_name' => $tag))->row_array();
            if (!$tag_exists) {
                $this->db->insert('tags', array('tag_name' => $tag));
                $tag_id = $this->db->insert_id();
            } else {
                $tag_id = $tag_exists['tag_id'];
            }
            //match the question with the tag in the table
            $this->db->insert('question_tags', array(
                'question_id' => $question_id,
                'tag_id' => $tag_id
            ));
        }
        return $question_id;
    }
    public function search_questions($keyword) {
        $this->db->select('questions.*, users.username as user_name, GROUP_CONCAT(tags.tag_name) as tag_names');
        $this->db->from('questions');
        $this->db->join('users', 'users.user_id = questions.user_id', 'left');
        $this->db->join('question_tags', 'question_tags.question_id = questions.question_id', 'left');
        $this->db->join('tags', 'tags.tag_id = question_tags.tag_id', 'left');
        $this->db->group_by('questions.question_id'); //group by question id to avoid duplicate rows
        $this->db->group_start();
        $this->db->like('title', $keyword);
        $this->db->or_like('tags.tag_name', $keyword);
        $this->db->group_end();
        $query = $this->db->get();
        $result = $query->result_array();
        //check if result is empty or not an array
        if (empty($result) || !is_array($result)) {
            return array();
        }
        //fetch and explode tags for each question separately
        foreach ($result as &$question) {
            if ($question['tag_names']) {
                $tags = explode(',', $question['tag_names']);
                $question['tags'] = $tags;
            } else {
                $question['tags'] = array(); //if no tags found, set an empty array
            }
            unset($question['tag_names']); //remove the temporary tag_names field
        }
        return $result;
    }
    public function get_answers($question_id) {
        $this->db->select('*');
        $this->db->from('answers');
        $this->db->where('question_id', $question_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_question($question_id) {
        $query = $this->db->get_where('questions', array('question_id' => $question_id));
        //check if the query has a result
        if ($query->num_rows() > 0) {
            //return the first row as an associative array
            return $query->row_array();
        } else {
            //return false if no question found
            return false;
        }
    }
    public function upvote_answer($answer_id, $question_id) {
        $user_id = $this->session->userdata('user_id');
        //check whether the user has already voted on this answer
        $existing_vote = $this->db->get_where('votes', [
            'user_id' => $user_id,
            'answer_id' => $answer_id,
            'question_id' => $question_id,
        ])->row();
        if ($existing_vote) {
            //user has voted, check the vote type
            if ($existing_vote->vote_type == 'upvote') {
            } else {
                //if user has downvoted, update it to upvote
                $this->db->where([
                    'user_id' => $user_id,
                    'answer_id' => $answer_id,
                    'question_id' => $question_id,
                ])->update('votes', ['vote_type' => 'upvote']);
            }
        } else {
            //user hasn't voted, add an upvote
            $this->db->insert('votes', [
                'user_id' => $user_id,
                'answer_id' => $answer_id,
                'question_id' => $question_id,
                'vote_type' => 'upvote',
            ]);
        }
    }
    public function downvote_answer($answer_id, $question_id) {
        $user_id = $this->session->userdata('user_id');
        $existing_vote = $this->db->get_where('votes', [
            'user_id' => $user_id,
            'answer_id' => $answer_id,
            'question_id' => $question_id,
        ])->row();
        if ($existing_vote) {
            if ($existing_vote->vote_type == 'downvote') {
            } else {
                //if user has upvoted, update it to downvote
                $this->db->where([
                    'user_id' => $user_id,
                    'answer_id' => $answer_id,
                    'question_id' => $question_id,
                ])->update('votes', ['vote_type' => 'downvote']);
            }
        } else {
            //user hasn't voted, add a downvote
            $this->db->insert('votes', [
                'user_id' => $user_id,
                'answer_id' => $answer_id,
                'question_id' => $question_id,
                'vote_type' => 'downvote',
            ]);
        }
    }
}
?>