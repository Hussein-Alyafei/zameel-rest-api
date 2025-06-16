<?php

namespace Database\Seeders;

use App\Models\College;
use App\Models\Major;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends BaseSeeder
{
    public function run(): void
    {
        College::insert($this->colleges);

        Subject::insert(CSV('subjects'));

        Major::insert(CSV('majors'));

        if (DB::connection()->getName() !== 'testing') {
            $this->call(FakeDataSeeder::class);
        }

        if (app()->environment('production') && app()->environment('local')) {
            $this->call(DemoSeeder::class);
        }
    }
}
