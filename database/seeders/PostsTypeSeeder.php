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
        $posts = [
            ["posts_type" => "Génération étiquette", "icon" => 'fas fa-barcode'],
            ["posts_type" => "Test", "icon" => 'fas fa-magic'],
            ["posts_type" => "Emballage", "icon" => 'fas fa-box-open'],
            // ["posts_type" => "reparation", "icon" => 'SNS'],

        ];

        foreach ($posts as $post) {
            PostsType::create($post);
        }
    }
}
