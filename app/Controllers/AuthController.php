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
        helper(['url']);
    }

    public function index()
    {
        helper(['form']);
        echo view('Auth/Login');
    }

    public function login(){
        // $db = \Config\Database::connect();
        $session = session();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $query = $this->db->query('SELECT * FROM users WHERE email = '.$this->db->escape($email));
        $data = $query->getRowArray();
        if ($data) {
            $pass = $data['password'];
            $authenticatePassword = $password === $pass ? $pass : null;
            if ($authenticatePassword) {
                $session_data = [
                    'id' => $data['id'],
                    'name' => $data['fullName'],
                    'email' => $data['email'],
                    'isLoggedIn' => TRUE
                ];

                $session->set($session_data);
                return redirect()->to(base_url());
            } else {
                $session->setFlashdata('msg', 'Email or Password is incorrect.');
                return redirect()->to('/login');
            }
        } else {
            $session->setFlashdata('msg', 'Email or Password is incorrect.');
            return redirect()->to('/login');
        }

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
