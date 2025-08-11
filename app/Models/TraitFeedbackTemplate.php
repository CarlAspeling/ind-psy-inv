<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TraitFeedbackTemplate extends Model
{
    use softDeletes;
    use hasfactory;

    protected $guarded = [];

    public function domain(): BelongsTo {
        return $this->belongsTo(Domain::class);
    }
}
