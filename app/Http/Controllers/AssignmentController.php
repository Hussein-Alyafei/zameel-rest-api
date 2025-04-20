<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignmentRequest;
use App\Models\Assignment;
use App\Policies\AssignmentPolicy;
use Orion\Http\Controllers\Controller;

class AssignmentController extends Controller
{
    protected $model = Assignment::class;

    protected $policy = AssignmentPolicy::class;

    protected $request = AssignmentRequest::class;
}
