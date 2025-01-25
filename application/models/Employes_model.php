<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employes_model extends CI_Model {
    private $table = 'employe';

    public function __construct() {
        parent::__construct();
    }

    // Create (Add) Employee
    public function create_employee($data) {
        return $this->db->insert($this->table, $data);
    }

    // Read (Get) Employees
    public function get_employees($filters = []) {
        if (!empty($filters)) {
            foreach ($filters as $key => $value) {
                $this->db->like($key, $value);
            }
        }
        return $this->db->get($this->table)->result();
    }

    // Update Employee
    public function update_employee($id, $data) {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    // Delete Employee
    public function delete_employee($id) {
        return $this->db->where('id', $id)->delete($this->table);
    }

    // Get Employee by ID
    public function get_employee_by_id($id) {
        return $this->db->where('id', $id)->get($this->table)->row();
    }
}