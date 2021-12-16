<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class AuthController extends BaseController
{
    public function index()
    {
        helper(['form']);
        echo view('login');
    }

    public function login(){
        $session = session();

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $query = $this->db->query("SELECT * FROM users WHERE users.email = $email");
        $data = $query->getResult();
        if ($data) {
            $pass = $data['password'];
            $authenticatePassword = password_verify($password, $pass);
            if ($authenticatePassword) {
                $session_data = [
                    'id' => $data['id'],
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'isLoggedIn' => TRUE
                ];

                $session->set($session_data);
                return redirect()->to('/profile');
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
            $session->set(['isLoggedIn' => FALSE]);
        }

    }
}
