<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'show permissions']);
        Permission::create(['name' => 'create permissions']);
        Permission::create(['name' => 'update permissions']);
        Permission::create(['name' => 'delete permissions']);
        Permission::create(['name' => 'show roles']);
        Permission::create(['name' => 'create roles']);
        Permission::create(['name' => 'update roles']);
        Permission::create(['name' => 'delete roles']);
        Permission::create(['name' => 'assign roles']);
        Permission::create(['name' => 'show users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'update users']);
        Permission::create(['name' => 'delete users']);
        Permission::create(['name' => 'show products and product features']);
        Permission::create(['name' => 'create products and product features']);
        Permission::create(['name' => 'update products and product features']);
        Permission::create(['name' => 'delete products and product features']);
        Permission::create(['name' => 'show orders']);
        Permission::create(['name' => 'create orders']);
        Permission::create(['name' => 'update orders']);
        Permission::create(['name' => 'delete orders']);
    }
}
