<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AttemptedQuestion extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'exam_attempt_id',
        'question_id',
        'selected_option_id',
    ];

    public function exam_attempt(): BelongsTo
    {
        return $this->belongsTo(ExamAttempt::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function option(): HasOne
    {
        return $this->hasOne(Option::class);
    }

}
