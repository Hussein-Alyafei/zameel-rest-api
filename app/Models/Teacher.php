<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Mockery\Matcher\Subset;

class Teacher extends Pivot
{
    public function subject() : BelongsTo {
        return $this->belongsTo(Subset::class);
    }
}
