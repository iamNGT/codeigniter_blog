<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class UserSeeder extends Seeder
{
    public function run()
    {
        for ($i=0; $i < 5; $i++) { 
            $this->db->table('users')->insert($this->insertUser());
        }

    }

    protected function insertUser() {
        $faker = Factory::create();
        return [
            'fullName' => $faker->name(),
            'email' => $faker->email(),
            'password' => $faker->password(8),
            'role_id' => $faker->randomElement(['1','2'])
        ];
    }
}
