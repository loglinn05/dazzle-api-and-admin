<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Amy',
            'email' => 'amy@gmail.com',
            'password' => bcrypt('12345678'),
        ])->syncRoles(['super admin']);
        User::create([
            'name' => 'Lina',
            'email' => 'lina@yahoo.com',
            'password' => bcrypt('abcd'),
        ])->syncRoles(['admin']);
        User::create([
            'name' => 'Eve',
            'email' => 'eve@example.com',
            'password' => bcrypt('qwerty'),
        ])->syncRoles(['staff']);
        User::create([
            'name' => 'Anna',
            'email' => 'anna@gmail.com',
            'password' => bcrypt('uiop'),
        ])->syncRoles(['customer']);
    }
}
