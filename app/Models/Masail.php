<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Masail extends Model
{
    protected $table = 'masail';
    
    protected $fillable = [
        'title',
        'question',
        'description',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function discussions(): BelongsToMany
    {
        return $this->belongsToMany(Discussion::class, 'masail_discussions');
    }

    public static function getRandomForExam(int $count = 10)
    {
        return self::inRandomOrder()->limit($count)->get();
    }
}
