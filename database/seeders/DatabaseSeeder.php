<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'user_type' => 0,
            'password' => bcrypt('password'),
            'image' => '/images/profile.png',
            'created_user_id' => 1
        ]);
    }
}
