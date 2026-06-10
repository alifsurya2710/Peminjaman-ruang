<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Room;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $rooms = Room::orderBy('name')->get();

        $query = Item::with(['room', 'borrowings' => function($q) {
            $q->whereIn('status', ['pending', 'approved'])->orderBy('created_at', 'desc');
        }]);

        // Filter by room if selected
        if ($request->filled('room_id')) {
            if ($request->room_id === 'none') {
                $query->whereNull('room_id');
            } else {
                $query->where('room_id', $request->room_id);
            }
        }

        $items = $query->get();

        $selectedRoomId = $request->room_id;

        return view('items.index', compact('items', 'rooms', 'selectedRoomId'));
    }

    public function create()
    {
        $rooms = Room::orderBy('name')->get();
        return view('items.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id'     => 'nullable|exists:rooms,id',
            'name'        => 'required|string|max:255',
            'total_stock' => 'required|integer|min:0',
        ]);

        $validated['available_stock'] = $validated['total_stock'];

        Item::create($validated);

        return redirect()->route('items.index')->with('success', 'Barang berhasil ditambahkan');
    }

    public function edit(Item $item)
    {
        $rooms = Room::orderBy('name')->get();
        return view('items.edit', compact('item', 'rooms'));
    }

    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'room_id'     => 'nullable|exists:rooms,id',
            'name'        => 'required|string|max:255',
            'total_stock' => 'required|integer|min:0',
        ]);

        // Calculate new available stock based on the difference
        $difference = $validated['total_stock'] - $item->total_stock;
        $newAvailableStock = $item->available_stock + $difference;

        if ($newAvailableStock < 0) {
            return back()->with('error', 'Total stok tidak bisa dikurangi sebanyak itu karena barang sedang dipinjam.');
        }

        $validated['available_stock'] = $newAvailableStock;

        $item->update($validated);

        return redirect()->route('items.index')->with('success', 'Barang berhasil diupdate');
    }

    public function destroy(Item $item)
    {
        if ($item->total_stock > $item->available_stock) {
            return back()->with('error', 'Barang tidak bisa dihapus karena sedang dipinjam.');
        }

        $item->delete();

        return redirect()->route('items.index')->with('success', 'Barang berhasil dihapus');
    }
}
