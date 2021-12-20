<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class PostTagsSeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 19; $i++) {
            $this->db->table('posts_tag')->insert($this->insertData());
        }
    }

    protected function insertData()
    {
        $faker = Factory::create();
        return [
            'tags_id' => $faker->randomElement(['1', '2', '3', '4', '5','6']),
            'posts_id' => $faker->randomElement(['1', '2', '3', '4', '5', 
                                                '6','7','8','9','10']),
        ];
    }
}
