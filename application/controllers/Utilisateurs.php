<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Utilisateurs extends CI_Controller {
    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('user') || $this->session->userdata('user')->role != 1) {
            redirect('index.php/auth/login');
        }
        $this->load->model('utilisateur_model');
        $this->load->helper('form');
        $this->load->library('form_validation');
    }

    public function index() {
        $data['utilisateurs'] = $this->utilisateur_model->get_utilisateures();
        $this->load->view('utilisateurs/index', $data);
    }

    public function add() {
        $this->form_validation->set_rules('nom', 'Nom', 'trim|required');
        $this->form_validation->set_rules('prenom', 'Prenom', 'trim|required');
        $this->form_validation->set_rules('login', 'Login', 'trim|required|is_unique[utilisateur.login]');
        $this->form_validation->set_rules('mot_de_passe', 'Password', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('role', 'Role', 'trim|required|in_list[1,2]');

        
        if ($this->input->is_ajax_request()) {
            if ($this->form_validation->run() == FALSE) {
                echo json_encode([
                    'status' => 'error',
                    'message' => validation_errors()
                ]);
                exit;
            }

            $user_data = [
                'nom' => $this->input->post('nom'),
                'prenom' => $this->input->post('prenom'),
                'login' => $this->input->post('login'),
                'mot_de_passe' => password_hash($this->input->post('mot_de_passe'), PASSWORD_DEFAULT),
                'role' => $this->input->post('role')
            ];

            if ($this->utilisateur_model->register_user($user_data)) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'User added successfully',
                    'redirect' => base_url('index.php/utilisateurs/add')
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Failed to add user'
                ]);
            }
            exit;
        }

        $this->load->view('utilisateurs/add');
    }

    public function edit($id = null) {
        if ($id === null) {
            $this->session->set_flashdata('error', 'Invalid user ID');
            redirect('index.php/utilisateurs/index');
        }

        $data['utilisateur'] = $this->utilisateur_model->get_user_by_id($id);

        if (!$data['utilisateur']) {
            $this->session->set_flashdata('error', 'User not found');
            redirect('index.php/utilisateurs/index');
        }

        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules('nom', 'Nom', 'trim|required');
            $this->form_validation->set_rules('prenom', 'Prenom', 'trim|required');
            $this->form_validation->set_rules('role', 'Role', 'trim|required|in_list[1,2]');

            if ($this->input->post('mot_de_passe')) {
                $this->form_validation->set_rules('mot_de_passe', 'Password', 'trim|min_length[6]');
            }

            if ($this->form_validation->run() == FALSE) {
                echo json_encode([
                    'status' => 'error',
                    'message' => validation_errors()
                ]);
                exit;
            }

            $update_data = [
                'nom' => $this->input->post('nom'),
                'prenom' => $this->input->post('prenom'),
                'role' => $this->input->post('role')
            ];

            if ($this->input->post('mot_de_passe')) {
                $update_data['mot_de_passe'] = password_hash($this->input->post('mot_de_passe'), PASSWORD_DEFAULT);
            }

            if ($this->utilisateur_model->update_user($id, $update_data)) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'User updated successfully',
                    'redirect' => base_url('index.php/utilisateurs/edit/'.$id)
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Failed to update user'
                ]);
            }
            exit;
        }

        $this->load->view('utilisateurs/edit', $data);
    }

    public function delete($id = null) {
        if ($this->session->userdata('user')->role != 1) {
            $this->session->set_flashdata('error', 'Unauthorized access');
            redirect('index.php/utilisateurs/index');
        }
    
        if ($id == $this->session->userdata('user')->id) {
            $this->session->set_flashdata('error', 'Cannot delete your own account');
            redirect('index.php/utilisateurs/index');
        }
    
        if ($id === null) {
            $this->session->set_flashdata('error', 'Invalid user ID');
            redirect('index.php/utilisateurs/index');
        }
    
        $utilisateur = $this->utilisateur_model->get_user_by_id($id);
        if (!$utilisateur) {
            $this->session->set_flashdata('error', 'User not found');
            redirect('index.php/utilisateurs/index');
        }
    
        if ($this->utilisateur_model->delete_user($id)) {
            $this->session->set_flashdata('success', 'User deleted successfully');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete user');
        }
    
        redirect('index.php/utilisateurs/index');
    }

    public function search() {
        $filters = [
            'nom' => $this->input->post('nom'),
            'prenom' => $this->input->post('prenom'),
            'login' => $this->input->post('login'),
            'role' => $this->input->post('role')
        ];

        $filters = array_filter($filters);

        $utilisateurs = $this->utilisateur_model->get_utilisateures($filters);

        $response = '';
        foreach($utilisateurs as $utilisateur) {
            $response .= '<tr>
                            <td>' . $utilisateur->nom . '</td>
                            <td>' . $utilisateur->prenom . '</td>
                            <td>' . $utilisateur->login . '</td>
                            <td>' . ($utilisateur->role == 1 ? 'Admin' : 'User') . '</td>
                            <td>
                                <a href="' . base_url('index.php/utilisateurs/edit/'.$utilisateur->id) . '" class="btn btn-sm btn-primary">Edit</a>
                                <a href="' . base_url('index.php/utilisateurs/delete/'.$utilisateur->id) . '" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</a>
                            </td>
                          </tr>';
        }

        echo $response;
    }
}