<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResponseSet extends Model
{
    use softDeletes;
    use hasfactory;
    protected $guarded = [];

    public function responseOptions(): hasMany
    {
        return $this->hasMany(ResponseOption::class);
    }

    public function questions(): hasMany
    {
        return $this->hasMany(Question::class);
    }
}
