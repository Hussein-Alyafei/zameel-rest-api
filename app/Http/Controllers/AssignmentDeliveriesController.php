<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\College;
use App\Models\Group;
use App\Policies\ApplyPolicy;
use App\Policies\DeliveryPolicy;
use App\Policies\MemberPolicy;
use Illuminate\Http\Request;
use Orion\Http\Controllers\RelationController;

class AssignmentDeliveriesController extends RelationController
{
    protected $model = Assignment::class;

    protected $policy = DeliveryPolicy::class;

    protected $relation = 'deliveries';

    public const EXCLUDE_METHODS = ['store', 'destroy', 'update', 'show', 'restore', 'associate' , 'dissociate'];

    public function alwaysIncludes(): array
    {
        return ['user'];
    }
}
