<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Welcome extends BaseController
{

    protected $db;

    public function __construct() {
        $this->db = \Config\Database::connect();    
        helper(['url','text','form']);
    }

    public function index()
    {
        $query = $this->db->query('SELECT * FROM posts ORDER BY created_at DESC LIMIT 5');
        $data['posts'] = $query->getResult();
        return view('home',$data);
    }

    public function showPost($slug) {
        $query = $this->db->query('SELECT * FROM posts WHERE slug ='.$this->db->escape($slug));
        $queryUser = $this->db->query('SELECT fullName FROM users WHERE id =' . $this->db->escape($query->getRowObject()->user_id));
        $queryCategory = $this->db->query('SELECT * FROM categories WHERE id =' . $this->db->escape($query->getRowObject()->category_id));
        $queryComment = $this->db->query('SELECT * FROM comments WHERE post_id =' . $this->db->escape($query->getRowObject()->id));
        $data = [
            'post' => $query->getRowObject(),
            'writer' => $queryUser->getRowObject()->fullName,
            'category' => $queryCategory->getRowObject(),
            'comments' => $queryComment->getResult()
        ];

        return view('show',$data);
    }

    public function showPostByCategory($name,$id) {
        $query = $this->db->query('SELECT * FROM posts WHERE category_id =' . $this->db->escape($id) .' LIMIT 5');
        $queryCatagory = $this->db->query('SELECT * FROM categories WHERE id =' . $this->db->escape($id));
        $data = [
            'posts' => $query->getResult(),
            'category' => $queryCatagory->getRowObject()
        ];

        return view('category_view', $data);   
    }
}
