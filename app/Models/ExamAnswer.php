<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamAnswer extends Model
{
    protected $fillable = [
        'exam_id',
        'masail_id',
        'discussion_id',
        'is_correct',
        'user_answer',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
        'user_answer' => 'boolean',
    ];

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    public function masail(): BelongsTo
    {
        return $this->belongsTo(Masail::class);
    }

    public function discussion(): BelongsTo
    {
        return $this->belongsTo(Discussion::class);
    }
}
