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
        $posts = PostsType::get();
        foreach ($posts as $post) {
            if ($post->id == 1) {
                Post::create(['post_name' => 'label_generator', 'posts_type_id' => $post->id, 'previous_post_id' => NULL, 'mac' => "mac1", 'code' => "200"]);
            }
            if ($post->id == 2) {
                for ($i = 1; $i <= 3; $i++) {
                    Post::create(['post_name' => 'Operator_ ' . $i + 1, 'posts_type_id' => $post->id, 'previous_post_id' => $i, 'mac' => "mac" . $i + 1, 'code' => "300"]);
                }
            }
            if ($post->id == 3) {
                Post::create(['post_name' => 'Packaging_1', 'posts_type_id' => $post->id, 'previous_post_id' => 1, 'mac' => "mac5", 'code' => "900"]);
            }
        }
    }
}
