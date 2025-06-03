<?php

namespace App\Http\Controllers;

use App\Models\College;
use App\Policies\MajorPolicy;
use Illuminate\Http\Request;
use Orion\Http\Controllers\RelationController;

class CollegeMajorsController extends RelationController
{
    protected $model = College::class;

    protected $policy = MajorPolicy::class;

    protected $relation = 'majors';

    public const EXCLUDE_METHODS = ['store', 'destroy', 'update', 'show', 'restore', 'associate' , 'dissociate'];
}
