<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AuthBackground;
use Illuminate\Support\Facades\Storage;

class AuthBackgroundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sourcePath = public_path('images/bg-login.jpg');
        $destinationFolder = 'auth-backgrounds';
        $destinationPath = $destinationFolder . '/bg-login.jpg';

        if (file_exists($sourcePath)) {
            if (!Storage::disk('public')->exists($destinationFolder)) {
                Storage::disk('public')->makeDirectory($destinationFolder);
            }

            Storage::disk('public')->put($destinationPath, file_get_contents($sourcePath));

            $hasActiveLogin = AuthBackground::where('is_active_login', true)->exists();
            $hasActiveForgot = AuthBackground::where('is_active_forgot_password', true)->exists();

            AuthBackground::create([
                'name' => 'Sistem Default Background',
                'image' => $destinationPath,
                'is_active_login' => !$hasActiveLogin,
                'is_active_forgot_password' => !$hasActiveForgot,
            ]);
        }
    }
}
