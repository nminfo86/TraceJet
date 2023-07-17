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
        $posts = [
            ["posts_type" => "generator", "icon" => 'fas fa-barcode'],
            ["posts_type" => "operator", "icon" => 'fas fa-magic'],
            ["posts_type" => "packaging", "icon" => 'fas fa-box-open'],
            ["posts_type" => "reparation", "icon" => 'SNS'],

        ];

        foreach ($posts as $post) {
            PostsType::create($post);
        }
    }
}
