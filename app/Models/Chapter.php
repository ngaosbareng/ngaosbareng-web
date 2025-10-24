<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chapter extends Model
{
    protected $fillable = [
        'book_id',
        'parent_id',
        'title',
        'description',
        'order',
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Chapter::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Chapter::class, 'parent_id')->orderBy('order');
    }

    public function discussions(): HasMany
    {
        return $this->hasMany(Discussion::class)->orderBy('order');
    }

    public function allDescendants(): HasMany
    {
        return $this->children()->with('allDescendants');
    }
}
