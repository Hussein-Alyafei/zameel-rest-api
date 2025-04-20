<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeliveryRequest;
use App\Models\Delivery;
use App\Policies\DeliveryPolicy;
use Orion\Http\Controllers\Controller;

class DeliveryController extends Controller
{
    protected $model = Delivery::class;

    protected $policy = DeliveryPolicy::class;

    protected $request = DeliveryRequest::class;

    public const EXCLUDE_METHODS = ['update'];
}
