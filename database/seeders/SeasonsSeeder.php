<?php

namespace Database\Seeders;

use App\Models\Season;
use Illuminate\Database\Seeder;

class SeasonsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Season::create(['title' => "All Seasons"]);
        Season::create(['title' => "Spring/Autumn"]);
        Season::create(['title' => "Summer"]);
        Season::create(['title' => "Winter"]);
    }
}
