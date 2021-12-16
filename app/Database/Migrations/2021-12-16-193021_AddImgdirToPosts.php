<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddImgdirToPosts extends Migration
{
    public function up()
    {
        $this->forge->addColumn('posts',['img_dir' => [
            'type' => 'VARCHAR',
            'constraint' => '255'
        ]]);
    }

    public function down()
    {
        //
    }
}
