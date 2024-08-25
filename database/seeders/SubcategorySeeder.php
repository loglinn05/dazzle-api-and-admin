<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class SubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = Category::where('title', 'Clothes')->first();
        $category->subcategories()->createMany([
            ['title' => "Men's clothes"],
            ['title' => "Women's clothes"],
        ]);

        $category = Category::where('title', 'Shoes')->first();
        $category->subcategories()->createMany([
            ['title' => "Men's shoes"],
            ['title' => "Women's shoes"],
        ]);

        $category = Category::where('title', 'Accessories')->first();
        $category->subcategories()->createMany([
            ['title' => "Men's accessories"],
            ['title' => "Women's accessories"],
        ]);
    }
}
