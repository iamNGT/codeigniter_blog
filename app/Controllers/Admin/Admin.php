<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Admin extends BaseController
{
    public function index()
    {
        return view('Admin/dashboard');
    }

    public function active_user()
    {
        $db = \Config\Database::connect();
        $user = $db->query('SELECT active FROM users WHERE id ='.$this->request->getVar('user_id'));
        $user= $db->query('UPDATE users SET active='.$this->request->getVar('status'));

        return $this->response->setJson(['success' => 'Status change successfully.']);
    }
}
