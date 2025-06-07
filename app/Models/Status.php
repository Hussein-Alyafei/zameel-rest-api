<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    public $timestamps = false;

    public const ACCEPTED = 1;

    public const PENDING = 2;

    public const REJECTED = 3;

    protected $fillable = [
        'name',
    ];
}
