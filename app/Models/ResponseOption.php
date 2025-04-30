<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResponseOption extends Model
{
    use hasFactory;
    use softDeletes;
    protected $guarded = [];

    public function responseSet(): BelongsTo
    {
        return $this->belongsTo(ResponseSet::class);
    }

    public function responses(): hasMany
    {
        return $this->hasMany(Response::class);
    }
}
