<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // opsi menggunakan seeder
        // eloquent
        // raw query
        // db
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => '12345678',
        ]);
    }
}
