<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class TagsSeeder extends Seeder
{
    public function run()
    {

        $this->db->table('tags')->insert(['name' => 'sports']);
        $this->db->table('tags')->insert(['name' => 'musics']);
        $this->db->table('tags')->insert(['name' => 'politics']);
        $this->db->table('tags')->insert(['name' => 'cinema']);
        $this->db->table('tags')->insert(['name' => 'affairs']);
        $this->db->table('tags')->insert(['name' => 'health']);


    }

}
