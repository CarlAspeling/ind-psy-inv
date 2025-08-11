<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class QuestionnaireAttempt extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $guarded = [];
    
    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->session_id)) {
                $model->session_id = Str::uuid();
            }
            if (empty($model->started_at)) {
                $model->started_at = now();
            }
        });
    }

    public function questionnaire(): BelongsTo
    {
        return $this->belongsTo(Questionnaire::class);
    }

    public function responses(): HasMany
    {
        return $this->hasMany(Response::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function isCompleted(): bool
    {
        return !is_null($this->completed_at);
    }
    
    public function markCompleted(): void
    {
        $this->update(['completed_at' => now()]);
    }
}
