<?php

namespace App\Http\Controllers;

use App\Models\Borrower;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowerController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Borrower::with('room');

        if ($user->isAdmin()) {
            $rooms = Room::all();
        } elseif ($user->role === 'sarpras') {
            $query->whereHas('room', function ($q) {
                $q->where('category_id', 1);
            });
            $rooms = Room::where('category_id', 1)->get();
        } else {
            $query->whereHas('room', function ($q) use ($user) {
                $q->where('category_id', $user->category_id);
            });
            $rooms = Room::where('category_id', $user->category_id)->get();
        }

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('room_id')) {
            $query->where('room_id', $request->room_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('borrow_date_from')) {
            $query->whereDate('borrow_date', '>=', $request->borrow_date_from);
        }

        if ($request->filled('borrow_date_to')) {
            $query->whereDate('borrow_date', '<=', $request->borrow_date_to);
        }

        if ($request->filled('class_name')) {
            $query->where('class_name', 'like', '%' . $request->class_name . '%');
        }

        $borrowers = $query->paginate(10);

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

        return view('borrowers.index', compact('borrowers', 'borrowerStats', 'rooms'));
    }

    public function create()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
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
            'return_date' => 'required|date|after_or_equal:borrow_date',
            'return_time' => 'nullable|date_format:H:i',
        ], [
            'return_date.after_or_equal' => 'Tanggal pengembalian tidak boleh kurang dari tanggal peminjaman.',
        ]);


        Borrower::create($validated);

        return redirect('/borrowers')->with('success', 'Data peminjam berhasil ditambahkan!');
    }

    public function edit(Borrower $borrower)
    {
        $borrower->load('room');
        $this->authorize('update', $borrower);

        $user = Auth::user();

        if ($user->isAdmin()) {
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
            'return_date' => 'required|date|after_or_equal:borrow_date',
            'return_time' => 'nullable|date_format:H:i',
        ], [
            'return_date.after_or_equal' => 'Tanggal pengembalian tidak boleh kurang dari tanggal peminjaman.',
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
