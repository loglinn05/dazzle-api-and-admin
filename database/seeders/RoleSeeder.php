<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'super admin'])->syncPermissions([
            'show permissions',
            'create permissions',
            'update permissions',
            'delete permissions',
            'show roles',
            'create roles',
            'update roles',
            'delete roles',
            'assign roles',
            'show users',
            'create users',
            'update users',
            'delete users',
            'show products and product features',
            'create products and product features',
            'update products and product features',
            'delete products and product features',
            'show orders',
            'create orders',
            'update orders',
            'delete orders'
        ]);
        Role::create(['name' => 'admin'])->syncPermissions([
            'show users',
            'create users',
            'update users',
            'delete users',
            'show products and product features',
            'create products and product features',
            'update products and product features',
            'delete products and product features',
            'show orders',
            'create orders',
            'update orders',
            'delete orders'
        ]);
        Role::create(['name' => 'staff'])->syncPermissions([
            'show users',
            'update users',
            'show products and product features',
            'create products and product features',
            'update products and product features',
            'delete products and product features',
            'show orders',
            'update orders',
        ]);
        Role::create(['name' => 'customer']);
    }
}
