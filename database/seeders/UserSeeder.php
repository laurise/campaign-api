<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $limit = 100;
        for ($i = 0; $i < $limit; $i++) {
            DB::connection('mysql2')->table('users')->insert([
                'name' => $faker->name,
                'email' => $faker->email,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
