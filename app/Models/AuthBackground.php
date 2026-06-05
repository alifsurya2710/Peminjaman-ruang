<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthBackground extends Model
{
    protected $table = 'auth_backgrounds';

    protected $fillable = [
        'name',
        'image',
        'is_active_login',
        'is_active_forgot_password',
    ];

    protected $casts = [
        'is_active_login' => 'boolean',
        'is_active_forgot_password' => 'boolean',
    ];

    public static function getActiveLoginUrl()
    {
        $bg = self::where('is_active_login', true)->first();
        return $bg ? asset('storage/' . $bg->image) : asset('images/bg-login.jpg');
    }

    public static function getActiveForgotPasswordUrl()
    {
        $bg = self::where('is_active_forgot_password', true)->first();
        return $bg ? asset('storage/' . $bg->image) : asset('images/bg-login.jpg');
    }
}
