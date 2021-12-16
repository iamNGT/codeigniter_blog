<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class PostsSeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 15; $i++) {
            $this->db->table('posts')->insert($this->insertPosts());
        }
    }

    protected function insertPosts()
    {
        $faker = Factory::create();
        return [
            'title' => $faker->sentence(),
            'slug' => $faker->slug(),
            'description' => $faker->text(),
            'img_dir' => $faker->image('uploads'),
            'user_id' => $faker->randomElement(['1', '2','3','4','5']),
            'category_id' => $faker->randomElement(['1', '2', '3', '4'])
        ];
    }
}
