<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(User::count() == 0) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]);

            User::create([
                'name' => 'Agent',
                'email' => 'agent@example.com',
                'password' => Hash::make('password'),
                'role' => 'agent',
            ]);
            
            User::create([
                'name' => 'Customer',
                'email' => 'customer@example.com',
                'password' => Hash::make('password'),
                'role' => 'customer',
            ]);
        }
    }
}
