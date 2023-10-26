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
            'email' => 'johndoe@msk.com',
            'password' => Hash::make('Secret@123')
        ]);
        User::factory()->create([
            'name' => 'Alex Johnson',
            'profile_picture_url' => '/img/u2.jpg',
            'email' => 'alexjohnson@msk.net',
            'password' => Hash::make('Secret@123')
        ]);
        User::factory()->create([
            'name' => 'Jane Smith',
            'profile_picture_url' => '/img/u3.jpg',
            'email' => 'janesmith@msk.com',
            'password' => Hash::make('Secret@123')
        ]);
        User::factory()->create([
            'name' => 'Emily Brown',
            'profile_picture_url' => '/img/u4.jpg',
            'email' => 'emilybrown@msk.com',
            'password' => Hash::make('Secret@123')
        ]);
        User::factory()->create([
            'name' => 'David Wilson',
            'profile_picture_url' => '/img/u5.jpg',
            'email' => 'davidwilson@msk.net',
            'password' => Hash::make('Secret@123')
        ]);
        User::factory()->create([
            'name' => 'Sarah Miller',
            'profile_picture_url' => '/img/u6.jpg',
            'email' => 'sarahmiller@msk.com',
            'password' => Hash::make('Secret@123')
        ]);
    }
}
