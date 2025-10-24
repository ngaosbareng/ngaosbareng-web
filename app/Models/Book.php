<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    protected $fillable = [
        'title',
        'description',
    ];

    public function chapters(): HasMany
    {
        return $this->hasMany(Chapter::class)->whereNull('parent_id')->orderBy('order');
    }

    public function allChapters(): HasMany
    {
        return $this->hasMany(Chapter::class)->orderBy('order');
    }
}
