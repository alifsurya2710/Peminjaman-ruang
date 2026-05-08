<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['name', 'description', 'type'];

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function getBadgeClasses(): string
    {
        $name = strtolower($this->name);
        if (str_contains($name, 'otomotif')) return 'bg-orange-50 text-orange-600 border-orange-100';
        if (str_contains($name, 'mesin')) return 'bg-red-50 text-red-600 border-red-100';
        if (str_contains($name, 'elektronika') || str_contains($name, 'mekatronika')) return 'bg-amber-50 text-amber-600 border-amber-100';
        if (str_contains($name, 'tekstil')) return 'bg-emerald-50 text-emerald-600 border-emerald-100';
        if (str_contains($name, 'tjkt')) return 'bg-indigo-50 text-indigo-600 border-indigo-100';
        if (str_contains($name, 'rpl') || str_contains($name, 'pplg')) return 'bg-sky-50 text-sky-600 border-sky-100';
        if (str_contains($name, 'bp')) return 'bg-slate-100 text-slate-600 border-slate-200';
        
        return 'bg-blue-50 text-blue-600 border-blue-100';
    }
}