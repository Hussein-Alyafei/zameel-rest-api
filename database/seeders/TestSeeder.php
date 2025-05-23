<?php

namespace Database\Seeders;

use App\Models\College;
use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(DatabaseSeeder::class);

        User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role_id' => User::ADMIN,
        ]);

        User::create([
            'name' => 'manager',
            'email' => 'manager@example.com',
            'password' => Hash::make('password'),
            'role_id' => User::MANAGER,
        ]);

        User::create([
            'name' => 'academic',
            'email' => 'academic@example.com',
            'password' => Hash::make('password'),
            'role_id' => User::ACADEMIC,
        ]);

        User::create([
            'name' => 'representer',
            'email' => 'representer@example.com',
            'password' => Hash::make('password'),
            'role_id' => User::REPRESENTER,
        ]);

        User::create([
            'name' => 'student',
            'email' => 'student@example.com',
            'password' => Hash::make('password'),
            'role_id' => User::STUDENT,
        ]);

        College::create([
            'name' => 'Test College without majors related to it',
        ]);

        Group::factory()->create();
    }
}
