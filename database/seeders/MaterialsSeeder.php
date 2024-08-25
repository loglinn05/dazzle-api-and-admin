<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Seeder;

class MaterialsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Material::create(['title' => "Linen"]);
        Material::create(['title' => "Wool"]);
        Material::create(['title' => "Cotton"]);
        Material::create(['title' => "Polyester"]);
        Material::create(['title' => "Silk"]);
        Material::create(['title' => "Chiffon"]);
        Material::create(['title' => "Denim"]);
        Material::create(['title' => "Sequins"]);
        Material::create(['title' => "Feathers"]);
        Material::create(['title' => "Leather"]);
        Material::create(['title' => "Suede"]);
        Material::create(['title' => "Crystals"]);
        Material::create(['title' => "Beads"]);
        Material::create(['title' => "Gold"]);
        Material::create(['title' => "Silver"]);
        Material::create(['title' => "Plastic"]);
    }
}
