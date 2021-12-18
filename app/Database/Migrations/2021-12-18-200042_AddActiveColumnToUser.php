<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddActiveColumnToUser extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users',[
            'active' => [
                'type' => 'BOOLEAN'
            ]
        ]);
    }

    public function down()
    {
        //
    }
}
