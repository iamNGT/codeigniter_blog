<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User;
use mysqli_sql_exception;

class AuthController extends BaseController
{

    protected $db ;

    public function __construct() {
        $this->db = \Config\Database::connect();
        helper(['url', 'form']);
    }
    
    public function index()
    {
        echo view('Auth/Login');
    }
    
    public function login(){
        $session = session();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $query = $this->db->query('SELECT * FROM users WHERE email = '.$this->db->escape($email));
        $data = $query->getRowArray();
        $role = $this->db->query('SELECT roles.name FROM roles WHERE id='.$data['role_id'])->getRowObject();
        if ($data) {
            $db_password = $data['password'];
            $authenticatePassword = password_verify($password, $db_password);
            if ($authenticatePassword) {
                $session_data = [
                    'id' => $data['id'],
                    'name' => $data['fullName'],
                    'email' => $data['email'],
                    'role' => $role->name,
                    'account_active' => $data['active'] == 1 ? TRUE : FALSE,
                    'isLoggedIn' => TRUE
                ];

                $session->set($session_data);
                return redirect()->to(base_url('/dashboard'));
            } else {
                $session->setFlashdata('msg', 'Email or Password is incorrect.');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('msg', 'Email or Password is incorrect.');
            return redirect()->to('/login');
        }

    }

    public function signup() {
        $data = [];
        echo view('Auth/Register', $data);
    }

    public function register() 
    {

        $session = session();
        $user = new User();

        if ($this->validate($user->getValidationRules())) {


            $data = [
                'fullName'     => $this->request->getVar('fullName'),
                'email'    => $this->request->getVar('email'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            ];
            $this->db->table('users')->insert($data);
            $session->setFlashdata('msg', 'Account created.');
            return redirect()->to('/login');
        } else {
            $data['errors'] = $this->validator;
            echo view('Auth/Register', $data);
        }

    }

    public function user_message() {
        return view('user_message');
    }

    public function logout() {
        $session = session();

        if($session->get('isLoggedIn')) {
            $session->set([
                'id' => '',
                'name' => '',
                'email' => '',
                'isLoggedIn' => FALSE
            ]);
            return redirect()->to(base_url());
        }

    }
}
