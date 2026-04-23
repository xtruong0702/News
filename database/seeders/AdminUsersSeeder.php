<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tài khoản admin chính
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Tổng biên tập',
                'password' => Hash::make('admin123'),
            ]
        );

        // Tài khoản biên tập viên 1
        User::updateOrCreate(
            ['email' => 'editor1@gmail.com'],
            [
                'name' => 'Biên tập viên Công nghệ',
                'password' => Hash::make('12345678'),
            ]
        );

        // Tài khoản biên tập viên 2
        User::updateOrCreate(
            ['email' => 'editor2@gmail.com'],
            [
                'name' => 'Biên tập viên Đời sống',
                'password' => Hash::make('12345678'),
            ]
        );
    }
}
