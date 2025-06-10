<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Group;
use App\Policies\BookPolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Orion\Concerns\DisablePagination;
use Orion\Http\Controllers\RelationController;

class GroupBooksController extends RelationController
{
    use DisablePagination;

    protected $model = Group::class;

    protected $policy = BookPolicy::class;

    protected $request = BookRequest::class;

    protected $relation = 'books';

    protected function buildIndexFetchQuery(Request $request, Model $parentEntity, array $requestedRelations): Relation
    {
        $query = parent::buildIndexFetchQuery($request, $parentEntity, $requestedRelations);

        Validator::make(
            ['year' => $request->query('year', 1)],
            ['year' => 'sometimes|integer|numeric']
        )->validate();

        return $query->where('year', $request->query('year', 1));
    }

    public const EXCLUDE_METHODS = ['store', 'update', 'restore', 'associate', 'dissociate'];

    protected function performFill(
        Request $request,
        Model $parentEntity,
        Model $entity,
        array $attributes,
        array $pivot
    ): void {
        $attributes['group_id'] = $parentEntity->id;
        $entity->fill($attributes);
    }

    public function filterableBy(): array
    {
        return [
            'subject_id',
            'group_id',
            'is_practical',
            'year',
            'semester',
            'created_at',
        ];
    }
}
