<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeliveryRequest;
use App\Models\Assignment;
use App\Policies\DeliveryPolicy;
use Orion\Http\Controllers\RelationController;

class AssignmentDeliveriesController extends RelationController
{
    protected $model = Assignment::class;

    protected $policy = DeliveryPolicy::class;

    protected $request = DeliveryRequest::class;

    protected $relation = 'deliveries';

    public const EXCLUDE_METHODS = ['update', 'show', 'restore', 'associate', 'dissociate'];

    public function alwaysIncludes(): array
    {
        return ['user'];
    }
}
