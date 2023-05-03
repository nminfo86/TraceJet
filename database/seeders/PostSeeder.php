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
        $i = 0;
        $posts_type = PostsType::get();
        foreach ($posts_type as $type) {
            if ($type->id == 1) {
                Post::create(['post_name' => 'label_generator', 'posts_type_id' => $type->id, 'previous_post_id' => NULL,  'code' => "100", "ip_address" => "10.0.0.100"]);
            }
            if ($type->id == 2) {
                // for ($i = 1; $i <= 3; $i++) {
                Post::create(['post_name' => 'operator ' . $i, 'posts_type_id' => $type->id, 'previous_post_id' => $type->id - 1, 'code' => "200", "ip_address" => "10.0.0." . $type->id . "0" . $i]);
                // }
            }
            if ($type->id == 3) {
                Post::create(['post_name' => 'packaging', 'posts_type_id' => $type->id, 'previous_post_id' => $type->id - 1,  'code' => "300", "ip_address" => "10.0.0." . $type->id . "00"]);
            }
        }
    }
}
