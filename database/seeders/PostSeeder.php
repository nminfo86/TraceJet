<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\PostsType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $posts = [
            ['post_name' => 'label_generator', 'posts_type_id' => 1, 'previous_post_id' => NULL,  'code' => "P-001", "ip_address" => "127.0.0.1", "section_id" => 1, "color" => "primary", 'printer_id' => 1],



            ['post_name' => 'operator 1', 'posts_type_id' => 2, 'previous_post_id' => 1,  'code' => "P-002", "ip_address" => "127.0.0.2", "section_id" => 1, "color" => "primary"],

            ['post_name' => 'packaging', 'posts_type_id' => 3, 'previous_post_id' => 2,  'code' => "P-003", "ip_address" => "127.0.0.3", "section_id" => 1, "color" => "primary"],

            ['post_name' => 'Réparation', 'posts_type_id' =>4, 'previous_post_id' => NULL,  'code' => "P-004", "ip_address" => "127.0.0.100", "section_id" => 1, "color" => "primary"],
        ];


        foreach ($posts as $post) {
            Post::create($post);
        }
    }
}
