<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //     $user = User::create([
        //         'username' => 'admin',
        //         'password' => Hash::make('123123'),
        //         'name' => 'admin',
        //         // 'role_id' => 1
        //     ]);
        //     $user->assignRole(['admin']);
    }
}