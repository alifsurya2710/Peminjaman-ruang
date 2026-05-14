<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    protected $fillable = ['category_id', 'name', 'capacity', 'description', 'image'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function borrowers(): HasMany
    {
        return $this->hasMany(Borrower::class);
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }
}