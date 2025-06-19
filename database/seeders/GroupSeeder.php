<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $group = Group::create([
            'join_year' => 2025,
            'division' => 'A',
            'major_id' => 2,
        ]);

        $student1 = User::create([
            'name' => 'حسين علي حسين عبدالحافظ',
            'email' => 'huss1@example.com',
            'password' => Hash::make('password'),
            'role_id' => Role::STUDENT,
            'email_verified_at' => now(),
        ]);

        $student2 = User::create([
            'name' => 'حسين علي حسين عبدالحافظ',
            'email' => 'huss2@example.com',
            'password' => Hash::make('password'),
            'role_id' => Role::STUDENT,
            'email_verified_at' => now(),
        ]);

        $group->members()->attach([$student1->id, $student2->id]);

        $group->teachers()->attach([4 => ['subject_id' => 1], 6 => ['subject_id' => 2], 7 => ['subject_id' => 3]]);

        $group = Group::create([
            'join_year' => 2025,
            'division' => 'A',
            'major_id' => 3,
        ]);

        $student1 = User::create([
            'name' => 'حسين علي حسين عبدالحافظ',
            'email' => 'huss3@example.com',
            'password' => Hash::make('password'),
            'role_id' => Role::STUDENT,
            'email_verified_at' => now(),
        ]);

        $student2 = User::create([
            'name' => 'حسين علي حسين عبدالحافظ',
            'email' => 'huss4@example.com',
            'password' => Hash::make('password'),
            'role_id' => Role::STUDENT,
            'email_verified_at' => now(),
        ]);

        $group->members()->attach([$student1->id, $student2->id]);

        $group->teachers()->attach([4 => ['subject_id' => 3], 6 => ['subject_id' => 2], 7 => ['subject_id' => 1]]);
    }
}
