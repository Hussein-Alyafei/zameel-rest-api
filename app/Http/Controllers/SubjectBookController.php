<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Orion\Http\Controllers\RelationController;

class SubjectBookController extends RelationController
{
    protected $model = Subject::class;

    protected $relation = 'books';
}
