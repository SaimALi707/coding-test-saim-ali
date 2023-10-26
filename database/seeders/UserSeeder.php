<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'John Doe',
            'profile_picture_url' => '/img/u1.jpg',
            'email' => 'johndoe@gmail.com',
            'password' => Hash::make('password')
        ]);
        User::factory()->create([
            'name' => 'Alex Johnson',
            'profile_picture_url' => '/img/u2.jpg',
            'email' => 'alexjohnson@gmail.net',
            'password' => Hash::make('password')
        ]);
        User::factory()->create([
            'name' => 'Jane Smith',
            'profile_picture_url' => '/img/u3.jpg',
            'email' => 'janesmith@gmail.com',
            'password' => Hash::make('password')
        ]);
        User::factory()->create([
            'name' => 'Emily Brown',
            'profile_picture_url' => '/img/u4.jpg',
            'email' => 'emilybrown@gmail.com',
            'password' => Hash::make('password')
        ]);
        User::factory()->create([
            'name' => 'David Wilson',
            'profile_picture_url' => '/img/u5.jpg',
            'email' => 'davidwilson@gmail.net',
            'password' => Hash::make('password')
        ]);
        User::factory()->create([
            'name' => 'Sarah Miller',
            'profile_picture_url' => '/img/u6.jpg',
            'email' => 'sarahmiller@gmail.com',
            'password' => Hash::make('password')
        ]);
    }
}
