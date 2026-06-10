<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'name',
        'total_stock',
        'available_stock'
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function borrowings()
    {
        return $this->hasMany(ItemBorrowing::class);
    }
}
