<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Welcome extends BaseController
{

    protected $db;

    public function __construct() {
        $this->db = \Config\Database::connect();    
    }

    public function index()
    {
        helper(['url']);
        $query = $this->db->query('SELECT * FROM posts ORDER BY created_at DESC LIMIT 5');
        $data['posts'] = $query->getResult();
        return view('home',$data);
    }

    public function showPost($slug) {
        $query = $this->db->query('SELECT * FROM posts WHERE slug ='.$this->db->escape($slug));
        $queryUser = $this->db->query('SELECT fullName FROM users WHERE id =' . $this->db->escape($query->getRowObject()->user_id));
        $data = [
            'post' => $query->getRowObject(),
            'writer' => $queryUser->getRowObject()->fullName 
        ];

        return view('show',$data);
    }
}
