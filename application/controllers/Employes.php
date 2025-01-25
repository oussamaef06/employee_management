<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employes extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user')) {
            redirect('index.php/auth/login');
        }
        $this->load->model('employes_model');
    }

    public function index() {
        $data['employees'] = $this->employes_model->get_employees();
        $this->load->view('employes/index', $data);
    }

    public function add() {
        if ($this->session->userdata('user')->role != 1) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Unauthorized access'
            ]);
            exit;
        }
    
        if ($this->input->is_ajax_request()) {
            $employee_data = [
                'nom' => $this->input->post('nom'),
                'prenom' => $this->input->post('prenom'),
                'mail' => $this->input->post('mail'),
                'adresse' => $this->input->post('adresse'),
                'telephone' => $this->input->post('telephone'),
                'poste' => $this->input->post('poste')
            ];
            $result = $this->employes_model->create_employee($employee_data);
    
            if ($result) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Employee added successfully',
                    'redirect' => base_url('index.php/employes/add')
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Failed to add employee'
                ]);
            }
            exit;
        }
        $this->load->view('employes/add');
    }

    public function edit($id = null) {
        if ($this->session->userdata('user')->role != 1) {
            redirect('index.php/employes/index');
        }
    
        if ($id === null) {
            $this->session->set_flashdata('error', 'Invalid employee ID');
            redirect('index.php/employes/edit');
        }
    
        $data['employee'] = $this->employes_model->get_employee_by_id($id);
    
        if (!$data['employee']) {
            $this->session->set_flashdata('error', 'Employee not found');
            redirect('index.php/employes/edit');
        }
    
        if ($this->input->is_ajax_request()) {
            $employee_data = [
                'nom' => $this->input->post('nom'),
                'prenom' => $this->input->post('prenom'),
                'mail' => $this->input->post('mail'),
                'adresse' => $this->input->post('adresse'),
                'telephone' => $this->input->post('telephone'),
                'poste' => $this->input->post('poste')
            ];
    
            if ($this->employes_model->update_employee($id, $employee_data)) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Employee updated successfully',
                    'redirect' => base_url('index.php/employes/edit/'.$id)
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Failed to update employee'
                ]);
            }
            exit;
        }
        $this->load->view('employes/edit', $data);
    }

    public function delete($id = null) {
        if ($this->session->userdata('user')->role != 1) {
            $this->session->set_flashdata('error', 'Unauthorized access');
            redirect('index.php/employes/index');
        }
    
        if ($id === null) {
            $this->session->set_flashdata('error', 'Invalid employee ID');
            redirect('index.php/employes/index');
        }
    
        $employee = $this->employes_model->get_employee_by_id($id);
        if (!$employee) {
            $this->session->set_flashdata('error', 'Employee not found');
            redirect('index.php/employes/index');
        }

        if ($this->employes_model->delete_employee($id)) {
            $this->session->set_flashdata('success', 'Employee deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete employee');
        }
    
        redirect('index.php/employes/index');
    }

    public function search() {
        $filters = [
            'nom' => $this->input->post('nom'),
            'prenom' => $this->input->post('prenom'),
            'mail' => $this->input->post('mail'),
            'adresse' => $this->input->post('adresse'),
            'telephone' => $this->input->post('telephone'),
            'poste' => $this->input->post('poste')
        ];
    
        $filters = array_filter($filters);
    
        $employees = $this->employes_model->get_employees($filters);
    
        $response = '';
        foreach($employees as $employee) {
            $response .= '<tr>
                            <td>' . $employee->nom . '</td>
                            <td>' . $employee->prenom . '</td>
                            <td>' . $employee->mail . '</td>
                            <td>' . $employee->telephone . '</td>
                            <td>' . $employee->poste . '</td>';
            if($this->session->userdata('user')->role == 1) {
                $response .= '<td>
                                <a href="' . base_url('index.php/employes/edit/'.$employee->id) . '" class="btn btn-sm btn-primary">Edit</a>
                                <a href="' . base_url('index.php/employes/delete/'.$employee->id) . '" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</a>
                              </td>';
            }
            $response .= '</tr>';
        }
    
        echo $response;
    }
}