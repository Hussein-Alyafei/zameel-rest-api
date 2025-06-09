<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplyRequest;
use App\Models\Apply;
use App\Models\Status;
use App\Policies\ApplyPolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Orion\Http\Controllers\Controller;

class ApplyController extends Controller
{
    protected $model = Apply::class;

    protected $policy = ApplyPolicy::class;

    protected $request = ApplyRequest::class;

    protected $pivotFillable = ['note'];

    public const EXCLUDE_METHODS = ['update', 'restore'];

    protected function performFill(Request $request, Model $entity, array $attributes): void
    {
        $attributes['user_id'] = Auth::user()->id;
        $attributes['status_id'] = Status::PENDING;
        $entity->fill($attributes);
    }

    public function filterableBy(): array
    {
        return [
            'user_id',
            'group_id',
            'status_id',
            'created_at',
            'updated_at',
        ];
    }
}
