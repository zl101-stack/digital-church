<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // SUPERADMIN
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('11111111'),
            'role' => 'superadmin'
        ]);

        // ADMIN
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('11111111'),
            'role' => 'admin'
        ]);

        // USER / JEMAAT
        User::create([
            'name' => 'Jemaat',
            'email' => 'user@gmail.com',
            'password' => Hash::make('11111111'),
            'role' => 'user'
        ]);
    }
}