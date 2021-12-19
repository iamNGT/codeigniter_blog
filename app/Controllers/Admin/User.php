<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\Database\Query;
use mysqli_sql_exception;
use PhpParser\Node\Stmt\TryCatch;

class User extends BaseController
{

    protected $db;
    protected $view_dir;
    protected $rules = [];

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        helper(['url', 'text', 'form']);
        $this->view_dir = 'Admin/user/';
        $this->rules    = [
            'fullName'     => 'required|alpha_numeric_space|min_length[6]',
            'email'        => 'required|valid_email',
            'role_id'     => 'required',
        ];
    }

    public function index()
    {
        $query = $this->db->query('SELECT users.id,fullName,email,active,roles.name as role 
                                    FROM users LEFT JOIN roles ON users.role_id = roles.id');
        
        $data['users'] = $query->getResult();

        return view($this->view_dir.'index',$data);
        
    }

    public function new() {
        $data['roles'] = $this->db->query('SELECT roles.id,roles.name FROM roles')->getResult();
        return view($this->view_dir . 'create',$data);
    }

    public function create() {
        if($this->request->getMethod() === 'post' && $this->validate($this->rules) ) {
            $query = $this->db->prepare(function ($db) {
                $sql = "INSERT INTO users( fullName, email,role_id,active) 
                    VALUES (?,?,?,?)";

                return (new Query($db))->setQuery($sql);
            });
            $query->execute(
                $this->db->escapeString($this->request->getPost('fullName')),
                $this->db->escapeString($this->request->getPost('email')),
                $this->db->escapeIdentifiers($this->request->getPost('role_id')),
                $this->db->escapeIdentifiers($this->request->getPost('active'))
            );
            session()->setFlashdata('success', "User added");
            return redirect()->to(base_url('/users'));
        }
        $data['roles'] = $this->db->query('SELECT roles.id,roles.name FROM roles')->getResult();
        $data['errors'] = $this->validator;
        return view($this->view_dir . 'create', $data);
    }

    public function edit(int $id) {
        $data['roles'] = $this->db->query('SELECT roles.id,roles.name FROM roles')->getResult();
        $data['user'] = $this->db->query('SELECT * FROM users WHERE id='.$id)->getRowObject();
        return view($this->view_dir . 'edit', $data);

    }

    public function update(int $id) {
        if ($this->request->getMethod() === 'post' && $this->validate($this->rules)) {
            $query = $this->db->prepare(function ($db) {
                $sql = "UPDATE users SET fullName=?,email=?,role_id=?,
                        active=? WHERE id=?";

                return (new Query($db))->setQuery($sql);
            });
            $query->execute(
                $this->db->escapeString($this->request->getPost('fullName')),
                $this->db->escapeString($this->request->getPost('email')),
                $this->db->escapeIdentifiers($this->request->getPost('role_id')),
                $this->db->escapeIdentifiers($this->request->getPost('active')),
                $this->db->escape($id)
            );
            session()->setFlashdata('success', "User edited");
            return redirect()->to(base_url('/users'));
        }
        $data['roles'] = $this->db->query('SELECT roles.id,roles.name FROM roles')->getResult();
        $data['user'] = $this->db->query('SELECT * FROM users WHERE id=' . $id)->getRowObject();
        $data['errors'] = $this->validator;
        return view($this->view_dir . 'edit', $data);
    }

    public function delete(int $id) {
        $query = $this->db->prepare(function ($db) {
            $sql = "DELETE FROM users WHERE id=?";

            return (new Query($db))->setQuery($sql);
        });

        $query->execute($this->db->escape($id));
        session()->setFlashdata('success', "User deleted");

        return redirect()->to(base_url('/users'));

    }
}
