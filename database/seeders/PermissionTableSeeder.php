<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'caliber-list',
            'caliber-create',
            'caliber-edit',
            'caliber-delete',
            'product-list',
            'product-create',
            'product-edit',
            'product-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'of-list',
            'of-create',
            'of-edit',
            'of-delete',
            'serial_number-list',
            'serial_number-create',
            'serial_number-edit',
            'serial_number-delete',
            'posts_type-list',
            'posts_type-create',
            'posts_type-edit',
            'posts_type-delete',
            'post-list',
            'post-create',
            'post-edit',
            'post-delete',
            'movement-list',
            'movement-create',
            'movement-edit',
            'movement-delete',
            'section-list',
            'section-create',
            'section-edit',
            'section-delete'
        ];
        foreach ($permissions as $permission) {
            // Permission::create(['name' => $permission]);
            Permission::create(['name' => $permission, 'guard_name' => "sanctum"]);
        }
        // , 'guard_name' => 'sanctum'
    }
}