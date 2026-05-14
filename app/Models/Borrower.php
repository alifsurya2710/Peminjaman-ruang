<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Borrower extends Model
{
    protected $fillable = [
        'room_id',
        'name',
        'email',
        'phone',
        'class_name',
        'purpose',
        'borrow_date',
        'borrow_time',
        'return_date',
        'return_time',
        'status',
    ];

    protected $casts = [
        'borrow_date' => 'date',
        'return_date' => 'date',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getDisplayStatusAttribute(): string
    {
        if ($this->status === 'approved') {
            $now = now();
            $returnDateTime = \Carbon\Carbon::parse($this->return_date->format('Y-m-d') . ' ' . $this->return_time);
            
            if ($now->greaterThan($returnDateTime)) {
                return 'finished';
            }
        }
        return $this->status;
    }

    public function isFinished(): bool
    {
        return $this->display_status === 'finished';
    }

    public function getBadgeClasses(): string
    {
        $status = $this->display_status;
        return match($status) {
            'pending' => 'bg-amber-50 text-amber-600 border-amber-100 animate-pulse',
            'approved' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
            'rejected' => 'bg-rose-50 text-rose-600 border-rose-100',
            'finished' => 'bg-slate-900 text-white border-slate-900 shadow-lg shadow-slate-200',
            default => 'bg-slate-100 text-slate-600 border-slate-200'
        };
    }

    public function getStatusLabel(): string
    {
        $status = $this->display_status;
        return match($status) {
            'pending' => 'Pending',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'finished' => 'Sudah Selesai',
            default => 'Unknown'
        };
    }
}

