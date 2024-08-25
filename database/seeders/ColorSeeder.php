<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Color::create(['code' => "#cdb4db"]);
        Color::create(['code' => "#ffc8dd"]);
        Color::create(['code' => "#ffafcc"]);
        Color::create(['code' => "#bde0fe"]);
        Color::create(['code' => "#a2d2ff"]);
        Color::create(['code' => "#f72585"]);
        Color::create(['code' => "#7209b7"]);
        Color::create(['code' => "#3a0ca3"]);
        Color::create(['code' => "#4361ee"]);
        Color::create(['code' => "#4cc9f0"]);
        Color::create(['code' => "#ffbe0b"]);
        Color::create(['code' => "#fb5607"]);
        Color::create(['code' => "#ff006e"]);
        Color::create(['code' => "#8338ec"]);
        Color::create(['code' => "#3a86ff"]);
    }
}
