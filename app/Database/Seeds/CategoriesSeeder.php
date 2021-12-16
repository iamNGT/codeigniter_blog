<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class CategoriesSeeder extends Seeder
{
    public function run()
    {

        $this->db->table('categories')->insert(['name' => 'sports']);
        $this->db->table('categories')->insert(['name' => 'musics']);
        $this->db->table('categories')->insert(['name' => 'politics']);
        $this->db->table('categories')->insert(['name' => 'cinema']);

    }

}
