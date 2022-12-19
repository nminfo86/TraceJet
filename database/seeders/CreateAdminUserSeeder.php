<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
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
<<<<<<< HEAD
        $super_admin_role = Role::create(['name' => 'super_admin','guard_name'=>'sanctum']);
=======
        $super_admin_role = Role::create(['name' => 'super_admin', 'guard_name' => 'sanctum']);
>>>>>>> 43b24d0671115a2e9a8971c7326d52895dbcb217
        $permissions = Permission::pluck('id', 'id');
        $super_admin_role->syncPermissions($permissions);

        $super_admin = User::create([
            // 'company_id' => 1,
            'section_id' => 1,
            'name' => 'super_admin',
            'username' => 'super_admin',
            'email' => 'admin@local.com',
            'roles_name' => [$super_admin_role->name],
            'password' => Hash::make('123123'),
        ]);

        $super_admin->assignRole($super_admin_role);
<<<<<<< HEAD
        // $super_admin->givePermissionTo(
        //     $permissions
        // );

        // user role
        // $user_role = Role::create(['name' => 'user', 'guard_name' => 'sanctum']);
=======
>>>>>>> 43b24d0671115a2e9a8971c7326d52895dbcb217
    }
}
