<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperadminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'superadmin@ruang.nekat.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('Superadmin27!'),
                'role' => 'superadmin',
                'is_active' => true,
            ]
        );
    }
}
