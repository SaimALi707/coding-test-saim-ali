<?php

namespace Database\Seeders;

use App\Models\Priority;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Priority::factory()
            ->count(5)
            ->sequence(
                ['name' => 'None', 'color' => '#ffffff'],
                ['name' => 'Low', 'color' => '#00D48D'],
                ['name' => 'Medium', 'color' => '#FFE024'],
                ['name' => 'High', 'color' => '#FF001D'],
                ['name' => 'Critical', 'color' => '#FF3C00'],)
            ->create();
    }
}
