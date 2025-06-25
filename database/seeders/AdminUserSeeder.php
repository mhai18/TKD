<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\UserType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'first_name' => 'Admin',
                'last_name' => 'User',
                'contact_number' => '09171234567',
                'user_type' => UserType::ADMIN,
                'password' => Hash::make('admin123'), // Default password
            ]
        );
    }
}
