<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exam extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'total_questions',
        'correct_answers',
        'score',
        'started_at',
        'completed_at',
        'status',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function examAnswers(): HasMany
    {
        return $this->hasMany(ExamAnswer::class);
    }

    public function calculateScore(): void
    {
        $totalQuestions = $this->examAnswers()->count();
        $correctAnswers = $this->examAnswers()->whereColumn('is_correct', 'user_answer')->count();
        
        $this->update([
            'correct_answers' => $correctAnswers,
            'score' => $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100) : 0,
        ]);
    }

    public function complete(): void
    {
        $this->calculateScore();
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }
}
