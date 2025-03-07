<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class Major extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'college_id',
        'degree_id',
        'years',
    ];

    public function groups(): HasMany
    {
        return $this->hasMany(Group::class);
    }

    public function degree(): BelongsTo
    {
        return $this->belongsTo(Degree::class);
    }

    public function college(): BelongsTo
    {
        return $this->belongsTo(College::class);
    }

    public function posts(): MorphMany
    {
        return $this->morphMany(Post::class, 'taggable');
    }

    public function beforeDestroy(Request $request, $major)
    {
        $date = $request->validate(['force' => 'sometimes|boolean']);
        $isForceDelete = ($date['force'] ?? 'false') === 'true';
        if ($isForceDelete && $major->groups()->exists()) {
            throw new UnprocessableEntityHttpException('Cannot delete college with majors');
        }
    }
}
