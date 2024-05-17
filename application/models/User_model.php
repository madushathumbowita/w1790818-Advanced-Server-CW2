<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    public function register($data) {
        $this->db->insert('users', $data);
    }
    public function login($username, $password) {
        $this->db->where('username', $username);
        $user = $this->db->get('users')->row();
        if ($user && password_verify($password, $user->password)) {
            return $user;
        } else {
            return FALSE;
        }
    }
    public function get_user($user_id) {
        $this->db->where('user_id', $user_id);
        return $this->db->get('users')->row_array();
    }
    public function update_user_name($user_id, $data) {
        $this->db->where('user_id', $user_id);
        $this->db->update('users', $data);
    }
    public function update_user_password($user_id, $password) {
        $data = array(
            'password' => password_hash($password, PASSWORD_DEFAULT)
        );
        $this->db->set('password', $password);
        $this->db->where('user_id', $user_id);
        $this->db->update('users');
    }
}
?>