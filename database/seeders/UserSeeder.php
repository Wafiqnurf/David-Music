<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name'      => 'Admin',
            'email'     => 'admin@example.com',
            'password'  => Hash::make('password'),
            'role'      => 'admin',
            'full_name' => 'Administrator',
        ]);

        // Create Regular User
        User::create([
            'name'        => 'John Doe',
            'email'       => 'user@example.com',
            'password'    => Hash::make('password'),
            'role'        => 'user',
            'full_name'   => 'John Doe',
            'nickname'    => 'John',
            'phone'       => '081234567890',
            'gender'      => 'male',
            'birth_place' => 'Jakarta',
            'birth_date'  => '1990-01-01',
            'address'     => 'Jakarta, Indonesia',
        ]);
    }
}
