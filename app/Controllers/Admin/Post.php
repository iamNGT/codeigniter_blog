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
        //role and id of the authenticated user
        $role = session()->get('role');
        $id = session()->get('id');

        if($role !== "admin") {
            $query = $this->db->query('SELECT * FROM posts WHERE posts.user_id ='.$id);
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
            $img_dir ="uploads/".random_string('numeric', 6).$img->getName();
            $img->move(ROOTPATH . 'public/uploads', random_string('numeric', 6) . $img->getName());
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
                foreach ($tags as $tag) {
                    $this->save_posts_tags($this->db->escape($tag), $this->db->escape($post_id->id));
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

    public function update($id) {
        $tags = $this->request->getPost('tags[]');
        if (count($tags) < 3) {

            session()->setFlashdata('error', "you need to chose at least 3 tags");
            return redirect()->to(base_url('/posts/'.$id.'/edit'));
        } else if ($this->request->getMethod() === 'post' && $this->validate($this->rules)) {

            $img = $this->request->getFile('img');
            $img_dir = "uploads/" . random_string('numeric', 6) . $img->getName();
            $img->move(ROOTPATH . 'public/uploads', random_string('numeric', 6) . $img->getName());
            $query = $this->db->prepare(function ($db) {
                $sql = "UPDATE posts SET title=?,slug=?,posts.description=?,img_dir=? WHERE id=?";

                return (new Query($db))->setQuery($sql);
            });
            $query->execute(
                $this->db->escapeString($this->request->getPost('title')),
                url_title($this->db->escapeString($this->request->getPost('title')), '-', true),
                $this->db->escapeString($this->request->getPost('description')),
                $this->db->escapeString($img_dir),
                $this->db->escapeIdentifiers($id),
            );

            if ($query) {
                $post_id = $this->db->query('SELECT posts.id FROM posts WHERE posts.title =' . $this->db->escape($this->request->getPost('title')))->getRowObject();
                $this->db->query('DELETE FROM posts_tag WHERE posts_id='.$id);
                foreach ($tags as $tag) {
                    $this->save_posts_tags($this->db->escape($tag), $this->db->escape($post_id->id));
                }

                session()->setFlashdata('success', "Post edited");
                return redirect()->to(base_url('/posts'));
            }
        }
        $data['tags'] = $this->db->query('SELECT tags.id,tags.name FROM tags')->getResult();
        $data['errors'] = $this->validator;
        return view($this->view_dir . 'edit', $data);
    }

    public function delete(int $id) {
        $this->db->query('DELETE FROM posts_tag WHERE posts_id='.$id);

        $query = $this->db->prepare(function ($db) {
            $sql = "DELETE FROM posts WHERE id=?";

            return (new Query($db))->setQuery($sql);
        });

        $query->execute($this->db->escape($id));
        session()->setFlashdata('success', "Posts deleted");

        return redirect()->to(base_url('/posts'));

    }

    protected function save_posts_tags ($tags, $post) {
        $this->db->query("INSERT INTO posts_tag(tags_id, posts_id) VALUES ($tags,$post)");  
    }
}
