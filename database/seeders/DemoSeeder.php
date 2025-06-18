<?php

namespace Database\Seeders;

use App\Jobs\ExtractBookContent;
use App\Jobs\MakeQuiz;
use App\Jobs\SummarizeBook;
use App\Models\Assignment;
use App\Models\Book;
use App\Models\College;
use App\Models\Group;
use App\Models\Major;
use App\Models\Member;
use App\Models\Notification;
use App\Models\Post;
use App\Models\Role;
use App\Models\Subject;
use App\Models\Teaching;
use App\Models\User;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemoSeeder extends BaseDemoSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::find(1)->update([
            'email_verified_at' => now(),
        ]);

        $student = User::create([
            'name' => 'حسين علي حسين عبدالحافظ',
            'email' => 'huss@example.com',
            'password' => Hash::make('password'),
            'role_id' => Role::STUDENT,
            'email_verified_at' => now(),
        ]);

        $represnter = User::create([
            'name' => 'عبدالرحمن صالح سالم الخطيب',
            'email' => 'khateeb@example.com',
            'password' => Hash::make('password'),
            'role_id' => Role::REPRESENTER,
            'email_verified_at' => now(),
        ]);

        $manager = User::create([
            'name' => 'د. ناظم الحداد',
            'email' => 'nadhem@example.com',
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

        $group = Group::create([
            'join_year' => 2025,
            'division' => 'A',
            'major_id' => 1,
        ]);

        Member::create([
            'user_id' => $student->id,
            'group_id' => $group->id,
            'is_representer' => false,
        ]);
        Member::create([
            'user_id' => $represnter->id,
            'group_id' => $group->id,
            'is_representer' => true,
        ]);

        $collegeID = College::where('name', 'كلية الهندسة والحاسبات')->value('id');
        $manager->colleges()->attach($collegeID);

        Teaching::create([
            'user_id' => $manager->id,
            'group_id' => $group->id,
            'subject_id' => 4,
        ]);

        $academics = User::where('role_id', Role::ACADEMIC)->get();
        $subjects = Subject::take(3)->get();

        foreach ($academics as $index => $academic) {
            $subject = $subjects[$index];
            $academic->colleges()->attach($collegeID);
            Teaching::create([
                'user_id' => $academic->id,
                'group_id' => $group->id,
                'subject_id' => $subject->id,
            ]);
        }

        foreach ($this->assignments as $item) {
            Assignment::create([
                'title' => $item['title'],
                'description' => $item['description'],
                'due_date' => now()->addDays($item['due_in_days']),
                'subject_id' => Subject::where('name', $item['subject'])->value('id'),
                'group_id' => $group->id,
            ]);
        }

        foreach ($this->books as $item) {
            $book = Book::create([
                'name' => $item['name'],
                'path' => $item['path'],
                'subject_id' => Subject::where('name', $item['subject'])->value('id'),
                'group_id' => $group->id,
                'is_practical' => false,
                'year' => 1,
                'semester' => 1,
            ]);

            Notification::create([
                'title' => 'هناك كتاب جديد',
                'content' => Str::limit($book->name, 30),
                'interests' => ['debug-all'],
            ]);

            Bus::chain([
                new ExtractBookContent($book),
                new SummarizeBook($book, 'الإنجليزية'),
                new MakeQuiz($book, 'english'),
            ])->dispatch();
        }

        Post::create([
            'user_id' => 1,
            'content' => 'تم اطلاق تطبيق زميل.',
        ]);

        Post::create([
            'user_id' => 1,
            'content' => 'يبدأالتسجيل في النسخة التجريبية من يوم غد.',
        ]);

        foreach ($academics as $index => $academic) {
            $subjectID = $academic->teachingSubjects->first()->id;

            Post::create([
                'user_id' => $academic->id,
                'subject_id' => $subjectID,
                'taggable_type' => Group::class,
                'taggable_id' => $group->id,
                'content' => $this->academicsContents[$index],
            ]);

            $postWithFile = Post::create([
                'user_id' => $academic->id,
                'subject_id' => $subjectID,
                'taggable_type' => Group::class,
                'taggable_id' => $group->id,
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
