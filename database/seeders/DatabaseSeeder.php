<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Caliber;
use App\Models\Product;
use Database\Seeders\OfSeeder;
use Illuminate\Database\Seeder;
use Database\Seeders\PostSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\SectionSeeder;
use Database\Seeders\PostsTypeSeeder;
use Database\Seeders\CreateAdminUserSeeder;
use Database\Seeders\PermissionTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
            SectionSeeder::class,
            PermissionTableSeeder::class,
            CreateAdminUserSeeder::class,
            PostsTypeSeeder::class,
            PostSeeder::class
        ]);

        Product::factory()->count(50)->create();
        Caliber::factory()->count(50)->create();
        $this->call(OfSeeder::class);
    }
}
