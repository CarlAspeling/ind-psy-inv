<?php

namespace App\Models;

use Filament\Models\Contracts\HasCurrentTenantLabel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Response extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function questionnaireAttempt(): BelongsTo
    {
        return $this->belongsTo(QuestionnaireAttempt::class);
    }

    public function responseOption(): BelongsTo
    {
        return $this->belongsTo(ResponseOption::class);
    }
//    public function questionnaires(): BelongsTo
//    {
//        return $this->belongsTo(Questionnaire::class);
//    }
}
