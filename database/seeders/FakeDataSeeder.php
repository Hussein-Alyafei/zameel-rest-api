<?php

namespace Database\Seeders;

use App\Models\File;
use App\Models\Group;
use App\Models\Post;
use App\Models\User;

class FakeDataSeeder extends BaseSeeder
{
    public function run(): void
    {
        User::factory(100)->create();

        $groups = Group::factory(20)->create();

        $groups->each(function ($group) {
            $usersIDs = User::inRandomOrder()->take(5)->get()->pluck('id')->toArray();
            $users = [];
            foreach ($usersIDs as $userID) {
                $users[$userID] = ['is_representer' => fake()->boolean()];
            }

            $group->members()->attach($users);
        });

        $groups->each(function ($group) {
            $usersIDs = User::inRandomOrder()->take(5)->get()->pluck('id')->toArray();
            $users = [];
            foreach ($usersIDs as $userID) {
                $users[$userID] = ['status_id' => fake()->numberBetween(1, 3), 'note' => 'Note'];
            }

            $group->applies()->attach($users);
        });

        Post::factory(50)->create();

        File::factory(100)->create();
    }
}
