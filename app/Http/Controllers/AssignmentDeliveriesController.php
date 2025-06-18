<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeliveryRequest;
use App\Models\Assignment;
use App\Models\Delivery;
use App\Policies\DeliveryPolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Orion\Http\Controllers\RelationController;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class AssignmentDeliveriesController extends RelationController
{
    protected $model = Assignment::class;

    protected $policy = DeliveryPolicy::class;

    protected $request = DeliveryRequest::class;

    protected $relation = 'deliveries';

    public const EXCLUDE_METHODS = ['update', 'restore', 'associate', 'dissociate'];

    protected function performFill(
        Request $request,
        Model $parentEntity,
        Model $entity,
        array $attributes,
        array $pivot
    ): void {
        if ($request->type === 'file') {
            $attributes['content'] = Storage::put('deliveries', $attributes['content']);
        }
        $entity->fill([...$attributes, 'user_id' => Auth::user()->id, 'assignment_id' => $parentEntity->id]);
    }

    protected function beforeSave(Request $request, Model $parentEntity, Model $entity)
    {
        $oldDelivery = Delivery::where('user_id', Auth::user()->id)->where('assignment_id', $parentEntity->id)->exists();
        if ($oldDelivery) {
            throw new ConflictHttpException('delivery exists.');
        }
    }

    protected function beforeDestroy(Request $request, Model $parentEntity, Model $delivery)
    {
        if ($delivery->type === 'file') {
            Storage::delete($delivery->content);
        }
    }

    public function alwaysIncludes(): array
    {
        return ['user'];
    }
}
