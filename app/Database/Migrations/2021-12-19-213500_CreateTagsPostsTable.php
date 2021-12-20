<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTagsPostsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'tags_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE
            ],
            'posts_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE
            ]
        ]);
        $this->forge->addForeignKey('tags_id', 'tags', 'id');
        $this->forge->addForeignKey('posts_id', 'posts', 'id');

        $this->forge->createTable('posts_tag');
    }

    public function down()
    {
        //
    }
}
