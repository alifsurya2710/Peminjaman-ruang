<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $schedules = Schedule::with('room')->paginate(10);
        } elseif ($user->role === 'sarpras') {
            $schedules = Schedule::whereHas('room', function ($query) {
                $query->where('category_id', 1);
            })->with('room')->paginate(10);
        } else {
            $schedules = Schedule::whereHas('room', function ($query) use ($user) {
                $query->where('category_id', $user->category_id);
            })->with('room')->paginate(10);
        }

        return view('schedules.index', compact('schedules'));
    }

    public function create()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $rooms = Room::all();
        } elseif ($user->role === 'sarpras') {
            $rooms = Room::where('category_id', 1)->get();
        } else {
            $rooms = Room::where('category_id', $user->category_id)->get();
        }

        $days = [
            'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat'
        ];


  
    return view('schedules.create', [
        'days' => $days,
        'rooms' => $rooms,  
    ]);

    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'day' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'block' => 'required|integer|min:1',
            'semester' => 'required|integer|min:1|max:6',
            'class_name' => 'nullable|string|max:255',
            'teacher_name' => 'nullable|string|max:255',
        ]);

        Schedule::create($validated);

        return redirect('/schedules')->with('success', 'Jadwal berhasil ditambahkan!');
    }

    public function show(Schedule $schedule)
    {
        return view('schedules.show', compact('schedule'));
    }

    public function edit(Schedule $schedule)
{
    $schedule->load('room');
    $this->authorize('update', $schedule); // Otorisasi

    $user = Auth::user();

    if ($user->role === 'admin') {
        $rooms = Room::all();
    } elseif ($user->role === 'sarpras') {
        $rooms = Room::where('category_id', 1)->get();
    } else {
        $rooms = Room::where('category_id', $user->category_id)->get();
    }

    $days = [
        'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'
    ];

    return view('schedules.edit', [
        'schedule' => $schedule, 
        'rooms' => $rooms,
        'days' => $days,
    ]);
}

    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'day' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'block' => 'required|integer|min:1',
            'semester' => 'required|integer|min:1|max:6',
            'class_name' => 'nullable|string|max:255',
            'teacher_name' => 'nullable|string|max:255',
        ]);

        $schedule->update($validated);

        return redirect('/schedules')->with('success', 'Jadwal berhasil diperbarui!');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect('/schedules')->with('success', 'Jadwal berhasil dihapus!');
    }
}
