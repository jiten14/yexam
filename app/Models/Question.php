<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Question extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'correct_option_id',
        'question',
    ];

    public function exam(): BelongsToMany
    {
        return $this->belongsToMany(Exam::class);
    }

    public function options(): BelongsToMany
    {
        return $this->belongsToMany(Option::class);
    }

    public function correctOption(): BelongsTo
    {
        return $this->belongsTo(Option::class);
    }

}
