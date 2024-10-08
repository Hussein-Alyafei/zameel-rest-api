<?php

namespace Database\Factories;

use App\Models\Apply;
use App\Models\Group;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplyFactory extends Factory
{
    protected $model = Apply::class;

    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'group_id' => Group::inRandomOrder()->first()->id,
            'status_id' => Status::inRandomOrder()->first()->id,
            'note' => fake()->sentence(),
        ];
    }
}
