<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Discussion extends Model
{
    protected $fillable = [
        'chapter_id',
        'title',
        'content',
        'order',
    ];

    public function chapter(): BelongsTo
    {
        return $this->belongsTo(Chapter::class);
    }

    public function masail(): BelongsToMany
    {
        return $this->belongsToMany(Masail::class, 'masail_discussions');
    }
}
