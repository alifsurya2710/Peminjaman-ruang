<?php

namespace App\Http\Controllers;

use App\Models\Borrower;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowerController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $borrowers = Borrower::with('room')->paginate(10);
        } elseif ($user->role === 'sarpras') {
            $borrowers = Borrower::whereHas('room', function ($query) {
                $query->where('category_id', 1);
            })->with('room')->paginate(10);
        } else {
            $borrowers = Borrower::whereHas('room', function ($query) use ($user) {
                $query->where('category_id', $user->category_id);
            })->with('room')->paginate(10);
        }

        $borrowerStats = [];
        foreach ($borrowers as $borrower) {
            $roomId = $borrower->room_id;
            if (!isset($borrowerStats[$roomId])) {
                $borrowerStats[$roomId] = [
                    'count' => 0,
                    'classes' => []
                ];
            }
            $borrowerStats[$roomId]['count']++;
            if ($borrower->class_name && !in_array($borrower->class_name, $borrowerStats[$roomId]['classes'])) {
                $borrowerStats[$roomId]['classes'][] = $borrower->class_name;
            }
        }

        return view('borrowers.index', compact('borrowers', 'borrowerStats'));
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

        $now = now();
        $currentTime = $now->format('H:i');
        $currentDate = $now->toDateString();

        $occupiedRoomIds = Borrower::where('status', 'approved')
            ->where(function ($query) use ($currentDate, $currentTime) {
                $query->where(function ($q) use ($currentDate, $currentTime) {
                    $q->where('borrow_date', $currentDate)
                      ->where('return_date', $currentDate)
                      ->where('borrow_time', '<=', $currentTime)
                      ->where('return_time', '>=', $currentTime);
                })->orWhere(function ($q) use ($currentDate, $currentTime) {
                    $q->where('borrow_date', $currentDate)
                      ->where('return_date', '>', $currentDate)
                      ->where('borrow_time', '<=', $currentTime);
                })->orWhere(function ($q) use ($currentDate, $currentTime) {
                    $q->where('borrow_date', '<', $currentDate)
                      ->where('return_date', $currentDate)
                      ->where('return_time', '>=', $currentTime);
                })->orWhere(function ($q) use ($currentDate) {
                    $q->where('borrow_date', '<', $currentDate)
                      ->where('return_date', '>', $currentDate);
                });
            })
            ->pluck('room_id')
            ->toArray();

        return view('borrowers.create', compact('rooms', 'occupiedRoomIds'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'class_name' => 'nullable|string|max:50',
            'purpose' => 'required|string',
            'borrow_date' => 'required|date',
            'borrow_time' => 'required|date_format:H:i',
            'return_date' => 'required|date',
            'return_time' => 'required|date_format:H:i',
        ]);


        Borrower::create($validated);

        return redirect('/borrowers')->with('success', 'Data peminjam berhasil ditambahkan!');
    }

    public function edit(Borrower $borrower)
    {
        $borrower->load('room');
        $this->authorize('update', $borrower);

        $user = Auth::user();

        if ($user->role === 'admin') {
            $rooms = Room::all();
        } elseif ($user->role === 'sarpras') {
            $rooms = Room::where('category_id', 1)->get();
        } else {
            $rooms = Room::where('category_id', $user->category_id)->get();
        }

        return view('borrowers.edit', compact('borrower', 'rooms'));
    }

    public function update(Request $request, Borrower $borrower)
    {
        $borrower->load('room');
        $this->authorize('update', $borrower);

        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'class_name' => 'nullable|string|max:50',
            'purpose' => 'required|string',
            'borrow_date' => 'required|date',
            'borrow_time' => 'required|date_format:H:i',
            'return_date' => 'required|date',
            'return_time' => 'required|date_format:H:i',
        ]);

        $borrower->update($validated);

        return redirect('/borrowers')->with('success', 'Data peminjam berhasil diperbarui!');
    }

    public function destroy(Borrower $borrower)
    {
        $borrower->load('room');
        $this->authorize('delete', $borrower);

        $borrower->delete();
        return redirect('/borrowers')->with('success', 'Data peminjam berhasil dihapus!');
    }

    public function approve(Borrower $borrower)
    {
        $borrower->load('room');
        $this->authorize('approve', $borrower);

        $borrower->update(['status' => 'approved']);
        return redirect('/borrowers')->with('success', 'Peminjaman disetujui!');
    }

    public function reject(Borrower $borrower)
    {
        $borrower->load('room');
        $this->authorize('reject', $borrower);

        $borrower->update(['status' => 'rejected']);
        return redirect('/borrowers')->with('success', 'Peminjaman ditolak!');
    }
}
