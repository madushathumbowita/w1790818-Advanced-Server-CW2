<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tag extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Tag_model');
    }
    public function list_tags() {
        $data['tags'] = $this->Tag_model->get_all_tags();
        $this->load->view('list_tags_view', $data);
    }
    public function view_questions_by_tag($tag_id) {
        $data['questions'] = $this->Tag_model->get_questions_by_tag($tag_id);
        $this->load->view('questions_by_tag_view', $data);
    }
}
?>