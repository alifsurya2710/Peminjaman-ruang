<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Borrower;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Hitung total berdasarkan role
        if ($user->isAdmin()) {
            $totalRooms = Room::count();
            $totalBorrowers = Borrower::count();
            $totalUsers = User::where('role', '!=', 'superadmin')->count();
            $totalSchedules = Schedule::count();
            $pendingBorrowers = Borrower::where('status', 'pending')->count();
        } elseif ($user->role === 'sarpras') {
            $totalRooms = Room::where('category_id', 1)->count();
            $totalBorrowers = Borrower::whereHas('room', function ($query) {
                $query->where('category_id', 1);
            })->count();
            $totalUsers = User::where('role', 'sarpras')->count();
            $totalSchedules = Schedule::whereHas('room', function ($query) {
                $query->where('category_id', 1);
            })->count();
            $pendingBorrowers = Borrower::where('status', 'pending')->whereHas('room', function ($query) {
                $query->where('category_id', 1);
            })->count();
        } else {
            $totalRooms = Room::where('category_id', $user->category_id)->count();
            $totalBorrowers = Borrower::whereHas('room', function ($query) use ($user) {
                $query->where('category_id', $user->category_id);
            })->count();
            $totalUsers = User::where('category_id', $user->category_id)->count();
            $totalSchedules = Schedule::whereHas('room', function ($query) use ($user) {
                $query->where('category_id', $user->category_id);
            })->count();
            $pendingBorrowers = Borrower::where('status', 'pending')->whereHas('room', function ($query) use ($user) {
                $query->where('category_id', $user->category_id);
            })->count();
        }

        return view('dashboard.index', compact(
            'totalRooms',
            'totalBorrowers',
            'totalUsers',
            'totalSchedules',
            'pendingBorrowers'
        ));
    }
}
