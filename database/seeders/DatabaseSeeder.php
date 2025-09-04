<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            # User related data
            PermissionSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            # Product attributes
            CategorySeeder::class,
            SubcategorySeeder::class,
            TypeSeeder::class,
            ColorSeeder::class,
            SizeSeeder::class,
            MaterialsSeeder::class,
            ManufacturerSeeder::class,
            SeasonsSeeder::class
        ]);
    }
}
