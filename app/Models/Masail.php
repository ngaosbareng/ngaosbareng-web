<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Masail extends Model
{
    protected $table = 'masail';
    
    protected $fillable = [
        'title',
        'question',
        'description',
    ];

    public function discussions(): BelongsToMany
    {
        return $this->belongsToMany(Discussion::class, 'masail_discussions');
    }

    public static function getRandomForExam(int $count = 10)
    {
        return self::inRandomOrder()->limit($count)->get();
    }
}
