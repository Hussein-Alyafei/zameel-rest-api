<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Orion\Http\Controllers\RelationController;

class SubjectAssignmentController extends RelationController
{
    protected $model = Subject::class;

    protected $relation = 'assignments';
}
