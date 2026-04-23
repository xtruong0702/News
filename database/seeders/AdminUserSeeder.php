<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tài khoản 1: admin@gmail.com / admin123
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin Chính',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]

        );

        // Tài khoản 2: editor@gmail.com / 12345678
        User::updateOrCreate(
            ['email' => 'editor@gmail.com'],
            [
                'name' => 'Biên tập viên',
                'password' => Hash::make('12345678'),
            ]
        );
    }
}
