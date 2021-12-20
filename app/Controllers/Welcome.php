<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Database\Query;

class Welcome extends BaseController
{

    protected $db;
    protected $pager;

    public function __construct() {
        $this->db = \Config\Database::connect(); 
        helper(['url','text','form']);
    }

    public function index()
    {
        $query = $this->db->query('SELECT * FROM posts ORDER BY created_at DESC');
        $data['posts'] = $query->getResult();
        return view('home',$data);
    }

    public function showPost($slug) {
        $query = $this->db->query('SELECT * FROM posts WHERE slug ='.$this->db->escape($slug));
        $queryUser = $this->db->query('SELECT fullName FROM users WHERE id =' . $this->db->escape($query->getRowObject()->user_id));
        $queryTags = $this->db->query('SELECT DISTINCT tags.name FROM posts_tag RIGHT JOIN tags ON posts_tag.tags_id = tags.id WHERE posts_tag.posts_id =' . $this->db->escape($query->getRowObject()->id)); 
        $data = [
            'post' => $query->getRowObject(),
            'tags' => $queryTags->getResult(),
            'writer' => $queryUser->getRowObject()->fullName
        ];

        return view('show',$data);
    }

    public function likeOrUnlike($slug) {
        if(url_is('like*')) {
            $value = intval($this->request->getPost('like')) + 1;
            $query = $this->db->prepare(function ($db) {
                $sql = "UPDATE posts SET posts.like=? WHERE id=?";
    
                return (new Query($db))->setQuery($sql);
            });
            $query->execute(
                $value,
                $this->db->escapeIdentifiers($this->request->getPost('id'))
            );
            session()->setFlashdata('msg', "you have like the post");
            return redirect()->to(base_url('/post/' . $slug));

        } elseif (url_is('unlike*')) {
            $value = intval($this->request->getPost('unlike')) + 1;
            $query = $this->db->prepare(function ($db) {
                $sql = "UPDATE posts SET posts.unlike=? WHERE id=?";

                return (new Query($db))->setQuery($sql);
            });
            $query->execute(
                $value,
                $this->db->escapeIdentifiers($this->request->getPost('id'))
            );
            session()->setFlashdata('msg', "you have unlike the post");
            return redirect()->to(base_url('/post/' . $slug));
        }

    }


}
