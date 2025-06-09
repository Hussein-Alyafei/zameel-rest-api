<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Subject;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            Book::create([
                'name' => fake()->sentence(3),
                'path' => 'books/7ge9YBnGgoIPF3KFfKy8qQYr7iXxURxyCrIBDvIZ.pdf',
                'subject_id' => Subject::inRandomOrder()->where('id', '>=', 1)->where('id', '<', 6)->first()->id,
                'group_id' => 1,
                'is_practical' => fake()->boolean(),
                'year' => fake()->numberBetween(1, 4),
                'semester' => fake()->numberBetween(1, 2),
            ]);
        }
    }
}
