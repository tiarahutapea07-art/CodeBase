<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
     public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@reusemarket.test'],
            [
                'name'     => 'Admin',
                'password' => 'admin12345', // otomatis di-hash oleh cast 'hashed' di model User
                'role'     => 'admin',
            ]
        );
    }
}