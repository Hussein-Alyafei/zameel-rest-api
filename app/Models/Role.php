<?php

namespace App\Models;

use App\Authorization\Abilities;
use App\Authorization\AuthorizationRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    use HasFactory;

    public $timestamps = false;

    public const ADMIN = 1;

    public const MANAGER = 2;

    public const ACADEMIC = 3;

    public const REPRESENTER = 4;

    public const STUDENT = 5;

    protected $fillable = [
        'name',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    // deprecated
    public function abilities()
    {
        return Abilities::getAbilities(AuthorizationRole::from($this->id));
    }
}
