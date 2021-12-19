<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\Database\Query;

class Role extends BaseController
{
    protected $db;
    protected $view_dir;
    protected $rules = [];

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        helper(['url', 'text', 'form']);
        $this->view_dir = 'Admin/role/';
        $this->rules    = [
            'name'     => 'required|alpha_numeric_space|min_length[5]',
        ];
    }

    public function index()
    {
        $query = $this->db->query('SELECT roles.id,roles.name  
                                    FROM roles ');

        $data['roles'] = $query->getResult();

        return view($this->view_dir . 'index', $data);
    }

    public function new()
    {
        return view($this->view_dir . 'create');
    }

    public function create()
    {
        if ($this->request->getMethod() === 'post' && $this->validate($this->rules)) {
            $query = $this->db->prepare(function ($db) {
                $sql = "INSERT INTO roles( roles.name) 
                    VALUES (?)";

                return (new Query($db))->setQuery($sql);
            });
            $query->execute(
                $this->db->escapeString($this->request->getPost('name')),
            );
            session()->setFlashdata('success', "Role added");
            return redirect()->to(base_url('/roles'));
        }
        $data['errors'] = $this->validator;
        return view($this->view_dir . 'create', $data);
    }

    public function edit(int $id)
    {
        $data['role'] = $this->db->query('SELECT * FROM roles WHERE id=' . $id)->getRowObject();
        return view($this->view_dir . 'edit', $data);
    }

    public function update(int $id)
    {
        if ($this->request->getMethod() === 'post' && $this->validate($this->rules)) {
            $query = $this->db->prepare(function ($db) {
                $sql = "UPDATE roles SET roles.name=? WHERE id=?";

                return (new Query($db))->setQuery($sql);
            });
            $query->execute(
                $this->db->escapeString($this->request->getPost('name')),
                $this->db->escape($id)
            );
            session()->setFlashdata('success', "Role edited");
            return redirect()->to(base_url('/roles'));
        }
        $data['role'] = $this->db->query('SELECT * FROM roles WHERE id=' . $id)->getRowObject();
        $data['errors'] = $this->validator;
        return view($this->view_dir . 'edit', $data);
    }

    public function delete(int $id)
    {
        $query = $this->db->prepare(function ($db) {
            $sql = "DELETE FROM roles WHERE id=?";

            return (new Query($db))->setQuery($sql);
        });

        $query->execute($this->db->escape($id));
        session()->setFlashdata('success', "Role deleted");

        return redirect()->to(base_url('/roles'));
    }
}
