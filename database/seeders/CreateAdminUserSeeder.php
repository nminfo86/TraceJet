<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //    Super admin
        $super_admin_role = Role::create(['name' => 'super_admin','guard_name'=>'sanctum']);
        $permissions = Permission::pluck('id', 'id');
        $super_admin_role->syncPermissions($permissions);

        $super_admin = User::create([
            // 'company_id' => 1,
            'name' => 'super_admin',
            'username' => 'super_admin',
            'email' => 'admin@local.com',
            'roles_name' => [$super_admin_role->name],
            'password' => bcrypt('123123'),
        ]);

        $super_admin->assignRole($super_admin_role);
        // $super_admin->givePermissionTo(
        //     $permissions
        // );

        // user role
        // $user_role = Role::create(['name' => 'user', 'guard_name' => 'sanctum']);
    }
}
