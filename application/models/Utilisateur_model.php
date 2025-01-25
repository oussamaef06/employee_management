<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Utilisateur_model extends CI_Model {
    private $table = 'utilisateur';

    public function __construct() {
        parent::__construct();
    }

    public function validate_user($login, $password) {
        $query = $this->db->get_where($this->table, array('login' => $login));
        $user = $query->row();
    
        if ($user && password_verify($password, $user->mot_de_passe)) {
            return $user;
        }
        
        return FALSE;
    }

    public function get_user_by_login($login) {
        $query = $this->db->get_where($this->table, array('login' => $login));
        return $query->row();
    }

    public function get_utilisateures($filters = []) {
        if (!empty($filters)) {
            foreach ($filters as $key => $value) {
                $this->db->like($key, $value);
            }
        }
        return $this->db->get($this->table)->result();
    }
    
    public function register_user($user_data) {
        return $this->db->insert($this->table, $user_data);
    }

    public function get_user_by_id($id) {
        return $this->db->get_where('utilisateur', ['id' => $id])->row();
    }

    public function create_user($data) {
        return $this->db->insert('utilisateur', $data);
    }

    public function update_user($id, $data) {
        return $this->db->where('id', $id)->update('utilisateur', $data);
    }

    public function delete_user($id) {
        return $this->db->where('id', $id)->delete('utilisateur');
    }
}
