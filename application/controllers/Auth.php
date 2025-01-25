<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Utilisateur_model');
    }

    public function register() {
        $this->load->view('auth/register');
    }

    public function index() {
        $this->load->view('auth/login');
    }

    public function login1() {
        header('Content-Type: application/json');

        $login = $this->input->post('login');
        $password = $this->input->post('password');

        $user = $this->Utilisateur_model->validate_user($login, $password);

        if ($user) {
            $this->session->set_userdata('user', $user);
            echo json_encode([
                'status' => 'success',
                'message' => 'Login successful',
                'user' => [
                    'id' => $user->id,
                    'nom' => $user->nom,
                    'prenom' => $user->prenom,
                    'role' => $user->role
                ]
            ]);
            exit;
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid login or password'
            ]);
            exit;
        }
    }

    public function register1() {
        header('Content-Type: application/json');

        try {
            $nom = $this->input->post('nom');
            $prenom = $this->input->post('prenom');
            $login = $this->input->post('login');
            $password = $this->input->post('password');
            $role = $this->input->post('role');

            if (empty($nom) || empty($prenom) || empty($login) || empty($password) || empty($role)) {
                throw new Exception('All fields are required');
            }

            $existing_user = $this->Utilisateur_model->get_user_by_login($login);
            if ($existing_user) {
                throw new Exception('Login already exists');
            }

            $user_data = [
                'nom' => $nom,
                'prenom' => $prenom,
                'login' => $login,
                'mot_de_passe' => password_hash($password, PASSWORD_BCRYPT),
                'role' => $role
            ];

            $result = $this->Utilisateur_model->register_user($user_data);

            if ($result) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'User registered successfully'
                ]);
            } else {
                throw new Exception('Failed to register user');
            }
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function register_process() {
        header('Content-Type: application/json');

        log_message('error', 'Registration POST Data: ' . print_r($_POST, true));

        try {
            $nom = trim($this->input->post('nom'));
            $prenom = trim($this->input->post('prenom'));
            $login = trim($this->input->post('login'));
            $password = $this->input->post('password');
            $role = $this->input->post('role');

            log_message('error', "Nom: $nom");
            log_message('error', "Prenom: $prenom");
            log_message('error', "Login: $login");
            log_message('error', "Role: $role");

            $errors = [];
            if (empty($nom)) $errors[] = 'Nom is required';
            if (empty($prenom)) $errors[] = 'Prenom is required';
            if (empty($login)) $errors[] = 'Login is required';
            if (empty($password)) $errors[] = 'Password is required';
            if (empty($role)) $errors[] = 'Role is required';

            if (!empty($errors)) {
                throw new Exception(implode(', ', $errors));
            }

            $existing_user = $this->Utilisateur_model->get_user_by_login($login);
            if ($existing_user) {
                throw new Exception('Login already exists');
            }

            $user_data = [
                'nom' => $nom,
                'prenom' => $prenom,
                'login' => $login,
                'mot_de_passe' => password_hash($password, PASSWORD_BCRYPT),
                'role' => $role
            ];

            $result = $this->Utilisateur_model->register_user($user_data);

            if ($result) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'User registered successfully'
                ]);
            } else {
                throw new Exception('Failed to register user');
            }
        } catch (Exception $e) {
            log_message('error', 'Registration Error: ' . $e->getMessage());
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('/');
    }
}
