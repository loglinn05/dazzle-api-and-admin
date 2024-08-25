<?php

namespace Database\Seeders;

use App\Models\Subcategory;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subcategory = Subcategory::where('title', "Men's clothes")->first();
        $subcategory->types()->createMany([
            ['title' => "Suits"],
            ['title' => "Outerwear"],
            ['title' => "Hoodies"],
            ['title' => "Sweaters"],
            ['title' => "T-Shirts"],
            ['title' => "Shirts"],
            ['title' => "Tank Tops"],
            ['title' => "Turtlenecks"],
            ['title' => "Pants"],
            ['title' => "Shorts"],
            ['title' => "Overalls"],
            ['title' => "Underwear"],
        ]);

        $subcategory = Subcategory::where('title', "Women's clothes")->first();
        $subcategory->types()->createMany([
            ['title' => "Suits"],
            ['title' => "Outerwear"],
            ['title' => "Hoodies"],
            ['title' => "T-Shirts"],
            ['title' => "Blouses"],
            ['title' => "Tops"],
            ['title' => "Turtlenecks"],
            ['title' => "Pants"],
            ['title' => "Shorts"],
            ['title' => "Skirts"],
            ['title' => "Dresses"],
            ['title' => "Overalls"],
            ['title' => "Underwear"],
            ['title' => "Beachwear"],
        ]);

        $subcategory = Subcategory::where('title', "Men's shoes")->first();
        $subcategory->types()->createMany([
            ['title' => "Sneakers"],
            ['title' => "Loafers"],
            ['title' => "Boots"],
            ['title' => "Oxfords"],
            ['title' => "Sandals"],
            ['title' => "Flip-flops"],
            ['title' => "Boat Shoes"],
            ['title' => "Moccasins"],
            ['title' => "Slippers"],
            ['title' => "Chelsea Boots"]
        ]);

        $subcategory = Subcategory::where('title', "Women's shoes")->first();
        $subcategory->types()->createMany([
            ['title' => "Heels"],
            ['title' => "Espadrilles"],
            ['title' => "Mules"],
            ['title' => "Oxfords"],
            ['title' => "Sandals"],
            ['title' => "Flip-flops"],
            ['title' => "Sneakers"],
            ['title' => "Loafers"],
            ['title' => "Flats"],
            ['title' => "Boots"]
        ]);

        $subcategory = Subcategory::where('title', "Men's accessories")->first();
        $subcategory->types()->createMany([
            ['title' => "Belts"],
            ['title' => "Ties"],
            ['title' => "Cufflinks"],
            ['title' => "Watches"],
            ['title' => "Wallets"],
            ['title' => "Hats"],
            ['title' => "Scarves"],
            ['title' => "Sunglasses"],
            ['title' => "Backpacks"],
            ['title' => "Gloves"]
        ]);

        $subcategory = Subcategory::where('title', "Women's accessories")->first();
        $subcategory->types()->createMany([
            ['title' => "Scarves"],
            ['title' => "Belts"],
            ['title' => "Gloves"],
            ['title' => "Hats"],
            ['title' => "Sunglasses"],
            ['title' => "Earrings"],
            ['title' => "Necklaces"],
            ['title' => "Bracelets"],
            ['title' => "Handbags"]
        ]);
    }
}
