<?php

namespace Database\Seeders;

use App\Models\PostsType;
use App\Enums\PostsTypeEnum;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PostsTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $posts = ['generator', 'operator', 'packaging', 'reparation'];

        foreach ($posts as $post) {
            PostsType::create(['posts_type' => $post]);
        }
    }
}