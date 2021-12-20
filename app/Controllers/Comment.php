<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Comment as ModelsComment;
use CodeIgniter\Database\Query;

class Comment extends BaseController
{

    protected $comment;
    protected $db;

    public function __construct() {
        $this->db = \Config\Database::connect();
    }

    public function getAllComment ($id) {
        $queryComment = $this->db->query('SELECT comments.name,comments.description FROM comments WHERE post_id =' . $this->db->escape($id));
        $comments = $queryComment->getResult();
        $data['comments'] = $comments;

        if(count($comments) > 0) {
            echo view('comment',$data);
        } else {
            echo '<span>no comment</span>';
        }
    }

    public function countComment($id) {
        $query = $this->db->query('SELECT COUNT(*) as count FROM comments WHERE post_id =' . $this->db->escape($id));
        $count = $query->getRowObject();

        return $this->response->setJSON(['count' => $count->count]);
    }

    public function addComment()
    {
        $formData = $this->request->getRawInput();
        if($this->request->getMethod() == "post"){
            $query = $this->db->prepare(function ($db) {
                $sql = "INSERT INTO comments( comments.name, comments.email, comments.description, comments.post_id)
                    VALUES (?,?,?,?)";

                return (new Query($db))->setQuery($sql);
            });
            $query->execute(
                $this->db->escapeString($formData['name']),
                $this->db->escapeString($formData['email']),
                $this->db->escapeString($formData['description']),
                $this->db->escapeString($formData['post_id']),
            );
            
            $response = [
                'success' => true,
                'msg' => 'comment added'

            ];
            return $this->response->setJSON($response);
        }
    }

}
