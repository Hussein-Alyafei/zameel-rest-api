<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\Book;
use App\Models\College;
use App\Models\Group;
use App\Models\Major;
use App\Models\Member;
use App\Models\Post;
use App\Models\Role;
use App\Models\Subject;
use App\Models\Teaching;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends BaseDemoSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'student',
            'email' => 'student@example.com',
            'password' => Hash::make('password'),
            'role_id' => Role::STUDENT,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'represnter',
            'email' => 'represnter@example.com',
            'password' => Hash::make('password'),
            'role_id' => Role::REPRESENTER,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'د. ناظم الحداد',
            'email' => 'Nadhem@example.com',
            'password' => Hash::make('password'),
            'role_id' => Role::MANAGER,
            'email_verified_at' => now(),
        ]);

        foreach ($this->academicNames as $academicName => $arabicName) {
            User::create([
                'name' => $arabicName,
                'email' => $academicName.'@example.com',
                'password' => Hash::make('password'),
                'role_id' => Role::ACADEMIC,
                'email_verified_at' => now(),
            ]);
        }

        Group::create([
            'join_year' => 2025,
            'division' => 'A',
            'major_id' => 1,
        ]);

        $student = User::where('role_id', Role::STUDENT)->first();
        $represnter = User::where('role_id', Role::REPRESENTER)->first();

        Member::create([
            'user_id' => $student->id,
            'group_id' => 1,
            'is_representer' => false,
        ]);

        Member::create([
            'user_id' => $represnter->id,
            'group_id' => 1,
            'is_representer' => true,
        ]);

        $collegeID = College::where('name', 'كلية الهندسة والحاسبات')->value('id');
        $manager = User::where('role_id', Role::MANAGER)->first();

        $manager->colleges()->attach($collegeID);

        Teaching::create([
            'user_id' => $manager->id,
            'group_id' => 1,
            'subject_id' => 4,
        ]);

        $academics = User::where('role_id', Role::ACADEMIC)->get();
        $subjects = Subject::take(3)->get();

        foreach ($academics as $index => $academic) {
            $subject = $subjects[$index];
            $academic->colleges()->attach($collegeID);
            Teaching::create([
                'user_id' => $academic->id,
                'group_id' => 1,
                'subject_id' => $subject->id,
            ]);
        }

        foreach ($this->assignments as $item) {
            Assignment::create([
                'title' => $item['title'],
                'description' => $item['description'],
                'due_date' => now()->addDays($item['due_in_days']),
                'subject_id' => Subject::where('name', $item['subject'])->value('id'),
                'group_id' => 1,
            ]);
        }

        foreach ($this->books as $item) {
            Book::create([
                'name' => $item['name'],
                'path' => $item['path'],
                'subject_id' => Subject::where('name', $item['subject'])->value('id'),
                'group_id' => 1,
                'is_practical' => false,
                'year' => 1,
                'semester' => 1,
            ]);
        }

        foreach ($academics as $index => $academic) {
            $subjectID = $academic->teachingSubjects->first()->id;

            Post::create([
                'user_id' => $academic->id,
                'subject_id' => $subjectID,
                'taggable_type' => Group::class,
                'taggable_id' => 1,
                'content' => $this->academicsContents[$index],
            ]);

            $postWithFile = Post::create([
                'user_id' => $academic->id,
                'subject_id' => $subjectID,
                'taggable_type' => Group::class,
                'taggable_id' => 1,
                'content' => $this->academicsContentsWithFile[$index],
            ]);

            $postWithFile->files()->create($this->files[$index]);
        }

        // Manager posts
        $managerSubjectID = $manager->teachingSubjects->first()->id;
        Post::create([
            'user_id' => $manager->id,
            'subject_id' => $managerSubjectID,
            'taggable_type' => Major::class,
            'taggable_id' => 2,
            'content' => 'يوم الأحد القادم سيتم عمل ندوة لطلاب تخصص تقنية المعلومات.',
        ]);

        for ($i = 0; $i < 3; $i++) {
            Post::create([
                'user_id' => $represnter->id,
                'subject_id' => rand(1, 4),
                'taggable_type' => Group::class,
                'taggable_id' => 1,
                'content' => $this->representerContents[$i],
            ]);
        }
    }
}
