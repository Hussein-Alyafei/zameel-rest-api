<?php

namespace Database\Factories;

use App\Models\College;
use App\Models\Group;
use App\Models\Major;
use App\Models\Post;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        $taggableType = fake()->randomElement([Group::class, Major::class, College::class, null]);

        $taggableId = null;
        if ($taggableType) {
            $taggableModel = app($taggableType); // This will create an instance of $taggableType
            $taggableId = $taggableModel->inRandomOrder()->first()->id;
        }

        return [
            'user_id' => User::whereIn('role_id', [1, 2, 3, 4])->inRandomOrder()->first()->id,
            'subject_id' => $taggableType === Group::class ? Subject::inRandomOrder()->first() : null,
            'taggable_id' => $taggableId,
            'taggable_type' => $taggableType,
            'content' => fake()->paragraph(),
        ];
    }
}
