<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 *
 * This model alludes to the domains a question can belong to.
 *
 */
class Domain extends Model
{
    use HasFactory;
    use softDeletes;

    protected $guarded = [];

    public function questions(): hasMany
    {
        return $this->hasMany(Question::class);
    }

    public function traitFeedbackTemplates(): HasMany {
        return $this->hasMany(TraitFeedbackTemplate::class);
    }
}
