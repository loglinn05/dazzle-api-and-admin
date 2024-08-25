<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = Category::where('title', 'Clothes')->first();
        $category->sizes()->createMany([
            ['title' => 'XXS'],
            ['title' => 'XS'],
            ['title' => 'S'],
            ['title' => 'M'],
            ['title' => 'L'],
            ['title' => 'XL'],
            ['title' => 'XXL'],
            ['title' => '3XL'],
            ['title' => '4XL']
        ]);

        $category = Category::where('title', 'Shoes')->first();
        $category->sizes()->createMany([
            ['title' => '35'],
            ['title' => '36'],
            ['title' => '37'],
            ['title' => '38'],
            ['title' => '39'],
            ['title' => '40'],
            ['title' => '41'],
            ['title' => '42'],
            ['title' => '43']
        ]);
    }
}
