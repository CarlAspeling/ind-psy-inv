<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Response extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];

    public function questions(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function questionnaires(): BelongsTo
    {
        return $this->belongsTo(Questionnaire::class);
    }
}
