<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Option extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'option',
    ];

    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class);
    }

}
