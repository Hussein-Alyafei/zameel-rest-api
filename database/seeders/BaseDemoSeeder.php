<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BaseDemoSeeder extends Seeder
{
    protected $academicNames = [
        'ahmedbelharth' => 'د. أحمد بلحارث',
        'lutfi' => 'د. لطفي الخنبري',
        'alibaleed' => 'د. علي بلعيد',
    ];

    protected $assignments = [
        [
            'title' => 'تصميم قاعدة بيانات لمستشفى',
            'description' => 'قم بتحليل احتياجات مستشفى متوسط الحجم وصمّم قاعدة بيانات تشمل جداول المرضى، الأطباء، المواعيد، الأقسام، والسجلات الطبية. يجب أن تراعي العلاقات بين الجداول وتضع مخطط ERD وتشرح أسباب اختيارك للهيكلية.',
            'due_in_days' => 30,
            'subject' => 'قواعد البيانات',
        ],
        [
            'title' => 'أنشاء فئة Class لطالب',
            'description' => 'اكتب برنامجًا بلغة تدعم البرمجة الكائنية (مثل بايثون أو جافا أو ++C) يقوم بإنشاء فئة (Class) باسم Student تحتوي على خصائص مثل الاسم والرقم الجامعي، ودالة لطباعة بيانات الطالب. أنشئ كائنين (Object) من هذه الفئة واطبع بيانات كل طالب.',
            'due_in_days' => 7,
            'subject' => 'برمجة كائنية التوجه',
        ],
        [
            'title' => 'إعداد وتأمين شبكة محلية لمؤسسة تعليمية',
            'description' => 'صمّم شبكة محلية (LAN) لمؤسسة تعليمية تضم 50 جهاز حاسوب موزعة على عدة أقسام. وضّح مخطط الشبكة، نوع الأجهزة المستخدمة، عناوين IP، وطرق تأمين الشبكة ضد الهجمات الشائعة مثل هجمات DoS والتجسس على البيانات.',
            'due_in_days' => 14,
            'subject' => 'إدارة الشبكات',
        ],
        [
            'title' => 'تحليل نظام إدارة الموارد البشرية',
            'description' => 'قم بدراسة نظام إدارة الموارد البشرية في شركة متوسطة، وحدد نقاط القوة والضعف في النظام الحالي. استخدم أدوات تحليل النظم مثل مخططات تدفق البيانات (DFD) واقترح تطويرات أو نظاماً جديداً يحسن من كفاءة العمل ويوضح دورة حياة النظام المقترح.',
            'due_in_days' => 10,
            'subject' => 'تحليل النظم',
        ],
    ];

    protected $books = [
        [
            'name' => 'مقدمة في قواعد البيانات',
            'path' => 'books/aPHB0VfoGNIVU7FQabAxckyJciOjNApm7uISGB8t.pdf',
            'subject' => 'قواعد البيانات',
        ],
        [
            'name' => 'مقدمة في إدارة الشبكات',
            'path' => 'books/25LPlUJ1HzfmFO9mZmA8aDGmJZ8odEvRBv6v06qL.pdf',
            'subject' => 'إدارة الشبكات',
        ],
        [
            'name' => 'مقدمة في برمجة كائنية التوجه',
            'path' => 'books/hTAIUZmUERfmJBPOYZlkihrQUDFgD8CSOvMk2ufc.pdf',
            'subject' => 'برمجة كائنية التوجه',
        ],
        [
            'name' => 'مقدمة في تحليل النظم',
            'path' => 'books/lWqev9B15PQUh6YSWCGbOXOKST9fLPoFxNeyCG1c.pdf',
            'subject' => 'تحليل النظم',
        ],
    ];

    protected $academicsContents = [
        'تذكير: تسليم مشروع المستشفى قبل نهاية الشهر.',
        'يرجى مراجعة مخطط الشبكة المحلية قبل الدرس القادم.',
        'سيتم إعادة اختبار للغائبين تاريخ 6/26',
    ];

    protected $academicsContentsWithFile = [
        'يرجى من جميع الطلاب مراجعة درجات المحصلة قبل الاعتماد',
        'تم رفع الفصل الأول بعنوان مقدمة عن إدارة الشبكات',
        'الملف المرفق عبارة عن المحاضرة القادمة',
    ];

    protected $files = [
        [
            'name' => 'محصلة قواعد البيانات',
            'type' => 'file',
            'url' => 'posts/files/FwbpMdHK5LqEprquIjxsTXhOZ0E2M2lYO7h4KaYv.pdf',
            'ext' => 'pdf',
        ],
        [
            'name' => 'مقدمة عن إدارة الشبكات',
            'type' => 'file',
            'url' => 'posts/files/GCJN8bVVRk6YSScAtZ6u5gl53PcITsX1gAtMJzLe.pdf',
            'ext' => 'pdf',
        ],
        [
            'name' => 'المحاضرة الثانية من البرمجة كائنية التوجه',
            'type' => 'file',
            'url' => 'posts/files/DabAAqzAZGk2eUh8OecSOPLmWAkiucjgPG4czT24.pdf',
            'ext' => 'pdf',
        ],
    ];

    protected $representerContents = [
        'تم تأجيل محاضرة الذكاء الاصطناعي للساعة 12',
        'تم تحديد موعد المناقشة النهائية تاريخ 6/18',
        'بكرة بسلم أوراق اختبار الشبكات بعد المحاضرة',
    ];
}
