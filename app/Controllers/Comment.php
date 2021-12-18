<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Comment as ModelsComment;

class Comment extends BaseController
{

    protected $comment;
    protected $db;

    public function __construct() {
        $this->comment = new ModelsComment();
        $this->db = \Config\Database::connect();
    }

    public function addComment()
    {
        if($this->request->getMethod() == "post"){
            if(!$this->validate($this->comment->getValidationRules())) {
                $response = [
                    'success' => false,
                    'msg' => "There are some errors, check your input value",
                ];

                return $this->response->setJSON($response);
            } else {
                $query = $this->db->query("INSERT INTO comments( 'name', 'email', 'description','post_id') 
                        VALUES ($this->db->escape($this->request->getPost('name')),$this->db->escape($this->request->getPost('email'),
                                $this->db->escape($this->request->getPost('description')),$this->db->escape($this->request->getPost('user_id')))");
                
                if($query->getResult()) {
                    $result = $this->db->query("SELECT * FROM comments WHERE post_id = $this->db->escape($this->request->getPost('user_id')");

                    $response = [
                        'success' => true,
                        'comments'=> $result->getResult(),
                        'msg' => 'comment added'

                    ];
                }

                return $this->response->setJSON($response);
            }
        }
    }
}
