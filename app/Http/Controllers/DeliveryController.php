<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeliveryRequest;
use App\Models\Delivery;
use App\Policies\DeliveryPolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Orion\Http\Controllers\Controller;

class DeliveryController extends Controller
{
    protected $model = Delivery::class;

    protected $policy = DeliveryPolicy::class;

    protected $request = DeliveryRequest::class;

    public const EXCLUDE_METHODS = ['update', 'restore'];

    protected function performFill(Request $request, Model $entity, array $attributes): void
    {
        if ($request->type === 'file') {
            $attributes['content'] = Storage::put('deliveries', $attributes['content']);
        }
        $entity->fill([...$attributes, 'user_id' => Auth::user()->id]);
    }

    protected function beforeDestroy(Request $request, Model $delivery)
    {
        if ($delivery->type === 'file') {
            Storage::delete($delivery->content);
        }
    }
}
