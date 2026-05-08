<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FloorPlan extends Model
{
    protected $fillable = [
        'title',
        'image',
        'description',
    ];
}
