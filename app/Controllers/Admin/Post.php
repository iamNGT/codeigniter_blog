<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\Database\Query;
use mysqli_sql_exception;
use PhpParser\Node\Stmt\TryCatch;

class Post extends BaseController
{

    protected $db;
    protected $view_dir;
    protected $rules = [];

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        helper(['url', 'text', 'form']);
        $this->view_dir = 'Admin/posts/';
        $this->rules    = [
            'title'     => 'required|min_length[6]',
            'description' => 'required',
        ];
    }

    public function index()
    {
        //id of the authenticated user
        $id = session()->get('id');
        //get he is role
        $queryUser = $this->db->query('SELECT roles.name as role 
                                    FROM users LEFT JOIN roles ON users.role_id = roles.id WHERE users.id ='.$id);
        $role = $queryUser->getRowObject()->role;
        if($role !== "admin") {
            $query = $this->db->query('SELECT * FROM posts WHERE posts.user ='.$id);
        } else {
            $query = $this->db->query('SELECT * FROM posts');
        }
        
        $data['posts'] = $query->getResult();

        return view($this->view_dir.'index',$data);
        
    }

    public function new() {
        $data['tags'] = $this->db->query('SELECT tags.id,tags.name FROM tags')->getResult();
        return view($this->view_dir . 'create',$data);
    }

    public function create() {
        $tags = $this->request->getPost('tags[]');
        if (count($tags) < 3) {
            session()->setFlashdata('error', "you need to chose at least 3 tags");
            return redirect()->to(base_url('/posts/new'));
        }else if($this->request->getMethod() === 'post' && $this->validate($this->rules) ) {
            $img = $this->request->getFile('img');
            $img_dir ='uploads/'. random_string('alnum', 6).$img->getName();
            $img->move(ROOTPATH . 'public/uploads',);
            $query = $this->db->prepare(function ($db) {
                $sql = "INSERT INTO posts( title, slug, posts.description, img_dir,posts.user_id) VALUES (?,?,?,?,?)";

                return (new Query($db))->setQuery($sql);
            });
            $query->execute(
                $this->db->escapeString($this->request->getPost('title')),
                url_title($this->db->escapeString($this->request->getPost('title')),'-',true),
                $this->db->escapeString($this->request->getPost('description')),
                $this->db->escapeString($img_dir),
                $this->db->escapeIdentifiers(session()->get('id')),
            );

            if($query) {
                $post_id = $this->db->query('SELECT posts.id FROM posts WHERE posts.title ='. $this->db->escape($this->request->getPost('title')))->getRowObject();
                
                for ($i=0; $i < count($tags); $i++) {
                        $query2 = $this->db->prepare(function ($db) {
                            $sql = "INSERT INTO posts_tag(tags_id, posts_id) VALUES (?,?)";
    
                            return (new Query($db))->setQuery($sql);
                        });
                        try {
                            $query2->execute(
                                $this->db->escape($tags[$i]),
                                $this->db->escape($post_id->id),
                            );
                        } catch (mysqli_sql_exception $e) {
                            return print_r($e);
                        }
                    }
                    session()->setFlashdata('success', "Post added");
                    return redirect()->to(base_url('/posts'));
            }

        }
        $data['tags'] = $this->db->query('SELECT tags.id,tags.name FROM tags')->getResult();
        $data['errors'] = $this->validator;
        return view($this->view_dir . 'create', $data);
    }

    public function edit(int $id) {
        $data['tags'] = $this->db->query('SELECT tags.id,tags.name FROM tags')->getResult();
        $data['post'] = $this->db->query('SELECT * FROM posts WHERE id='.$id)->getRowObject();
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
            $sql = "DELETE FROM posts WHERE id=?";

            return (new Query($db))->setQuery($sql);
        });

        $query->execute($this->db->escape($id));
        session()->setFlashdata('success', "Posts deleted");

        return redirect()->to(base_url('/posts'));

    }
}
