<?php

namespace Database\Seeders;

use App\Models\College;
use App\Models\Group;
use App\Models\Role;
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

        User::find(1)->update([
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'manager',
            'email' => 'manager@example.com',
            'password' => Hash::make('password'),
            'role_id' => Role::MANAGER,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'academic',
            'email' => 'academic@example.com',
            'password' => Hash::make('password'),
            'role_id' => Role::ACADEMIC,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'representer',
            'email' => 'representer@example.com',
            'password' => Hash::make('password'),
            'role_id' => Role::REPRESENTER,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'student',
            'email' => 'student@example.com',
            'password' => Hash::make('password'),
            'role_id' => Role::STUDENT,
            'email_verified_at' => now(),
        ]);

        College::create([
            'name' => 'Test College without majors related to it',
        ]);

        Group::factory()->create();
    }
}
