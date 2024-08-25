<?php

namespace Database\Seeders;

use App\Models\Manufacturer;
use Illuminate\Database\Seeder;

class ManufacturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Manufacturer::create(['name' => "Zara"]);
        Manufacturer::create(['name' => "H&M"]);
        Manufacturer::create(['name' => "New Look"]);
        Manufacturer::create(['name' => "Next"]);
        Manufacturer::create(['name' => "Victoria's Secret"]);
        Manufacturer::create(['name' => "Boohoo"]);
        Manufacturer::create(['name' => "Hugo Boss"]);
        Manufacturer::create(['name' => "C&A"]);
        Manufacturer::create(['name' => "Pierre Cardin"]);
        Manufacturer::create(['name' => "Lanvin"]);
        Manufacturer::create(['name' => "Marks & Spencer"]);
    }
}
