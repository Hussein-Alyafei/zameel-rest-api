<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 500; $i++) {
            $post = Post::create([
                'content' => fake()->sentence(rand(10, 25)),
                'user_id' => 1,
            ]);

            $num = rand(1, 4);

            if ($num > 2) {
                $type = ($num === 3) ? 'file' : 'image';
                $ext = ($num === 3) ? 'zip' : 'webp';
                $url = ($num === 3) ? 'posts/files/pgV9UhOWhugaJfrIwjBvPVetmINWW4OBWRuSNWBW.zip' : 'posts/images/05pqskDm4pMrgCCKM5rh3q4IzQCx81WgvXXQXwn9.webp';

                $post->files()->create([
                    'type' => $type,
                    'ext' => $ext,
                    'name' => fake()->sentence(3).$ext,
                    'url' => $url,
                ]);
            }
        }
    }
}
