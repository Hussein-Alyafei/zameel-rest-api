<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'join_year',
        'division',
        'major_id',
    ];

    public function applies(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'group_user_applies')
            ->using(Apply::class);
    }

    public function members(): belongsToMany
    {
        return $this->belongsToMany(User::class, 'group_user_members')
            ->using(Member::class);
    }

    public function major(): BelongsTo
    {
        return $this->belongsTo(Major::class);
    }

    public function posts(): MorphMany
    {
        return $this->morphMany(Post::class, 'taggable');
    }
}
