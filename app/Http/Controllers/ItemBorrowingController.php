<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ItemBorrowing;
use App\Models\User;
use App\Notifications\ItemBorrowedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemBorrowingController extends Controller
{
    public function index()
    {
        $borrowings = ItemBorrowing::with(['item', 'user'])->latest()->get();
        return view('item_borrowings.index', compact('borrowings'));
    }

    public function create()
    {
        $items = Item::with('room')->where('available_stock', '>', 0)->get();
        $rooms = \App\Models\Room::orderBy('name')->get();
        return view('item_borrowings.create', compact('items', 'rooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id'       => 'required|exists:items,id',
            'borrower_name' => 'required|string|max:255',
            'class_name'    => 'nullable|string|max:100',
            'department'    => 'nullable|string|max:150',
            'purpose'       => 'required|string|max:255',
            'amount'        => 'required|integer|min:1',
            'borrow_date'   => 'required|date',
            'return_date'   => 'required|date|after_or_equal:borrow_date',
        ]);

        $item = Item::findOrFail($validated['item_id']);

        if ($validated['amount'] > $item->available_stock) {
            return back()->with('error', 'Jumlah pinjaman melebihi stok yang tersedia (' . $item->available_stock . ' unit).');
        }

        $validated['user_id'] = Auth::id();
        $validated['status']  = 'pending';

        $borrowing = ItemBorrowing::create($validated);

        // Notify all admin, superadmin, and sarpras users
        $admins = User::whereIn('role', ['admin', 'superadmin', 'sarpras'])->get();
        foreach ($admins as $admin) {
            $admin->notify(new ItemBorrowedNotification($borrowing));
        }

        return redirect()->route('item_borrowings.index')
            ->with('swal_success', 'Permintaan peminjaman ' . $item->name . ' sebanyak ' . $validated['amount'] . ' unit berhasil diajukan! Menunggu persetujuan.');
    }

    public function edit(ItemBorrowing $itemBorrowing)
    {
        return view('item_borrowings.edit', compact('itemBorrowing'));
    }

    public function update(Request $request, ItemBorrowing $itemBorrowing)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected,finished',
        ]);

        $oldStatus = $itemBorrowing->status;
        $newStatus = $validated['status'];

        $item = $itemBorrowing->item;

        if ($oldStatus !== 'approved' && $newStatus === 'approved') {
            // Deduct stock
            if ($itemBorrowing->amount > $item->available_stock) {
                return back()->with('error', 'Stok tidak mencukupi untuk menyetujui peminjaman ini.');
            }
            $item->decrement('available_stock', $itemBorrowing->amount);
        } elseif ($oldStatus === 'approved' && ($newStatus === 'finished' || $newStatus === 'rejected' || $newStatus === 'pending')) {
            // Return stock
            $item->increment('available_stock', $itemBorrowing->amount);
        }

        $itemBorrowing->update($validated);

        $message = match($newStatus) {
            'approved'  => "Peminjaman <b>{$item->name}</b> sebanyak {$itemBorrowing->amount} unit telah <b>Disetujui</b>. Stok berkurang dari " . ($item->available_stock + $itemBorrowing->amount) . " menjadi {$item->fresh()->available_stock}.",
            'finished'  => "Peminjaman <b>{$item->name}</b> dinyatakan <b>Selesai</b>. Stok kembali ditambah {$itemBorrowing->amount} unit.",
            'rejected'  => "Peminjaman <b>{$item->name}</b> telah <b>Ditolak</b>.",
            default     => 'Status peminjaman berhasil diupdate.',
        };

        return redirect()->route('item_borrowings.index')->with('swal_success', $message);
    }

    public function destroy(ItemBorrowing $itemBorrowing)
    {
        if ($itemBorrowing->status === 'approved') {
            $itemBorrowing->item->increment('available_stock', $itemBorrowing->amount);
        }
        
        $itemBorrowing->delete();

        return redirect()->route('item_borrowings.index')->with('swal_success', 'Data peminjaman berhasil dihapus.');
    }

    public function approve(ItemBorrowing $itemBorrowing)
    {
        if ($itemBorrowing->status !== 'pending') {
            return back()->with('swal_error', 'Hanya peminjaman berstatus Pending yang bisa disetujui.');
        }

        $item = $itemBorrowing->item;

        if ($itemBorrowing->amount > $item->available_stock) {
            return back()->with('swal_error', 'Stok tidak mencukupi! Tersedia: ' . $item->available_stock . ' unit, diminta: ' . $itemBorrowing->amount . ' unit.');
        }

        $item->decrement('available_stock', $itemBorrowing->amount);
        $itemBorrowing->update(['status' => 'approved']);

        return redirect()->route('item_borrowings.index')
            ->with('swal_success', "Peminjaman <b>{$item->name}</b> oleh <b>{$itemBorrowing->borrower_name}</b> telah <b>Disetujui</b>. Stok berkurang {$itemBorrowing->amount} unit (tersisa {$item->fresh()->available_stock}).");
    }

    public function reject(ItemBorrowing $itemBorrowing)
    {
        if ($itemBorrowing->status === 'approved') {
            $itemBorrowing->item->increment('available_stock', $itemBorrowing->amount);
        }

        $item = $itemBorrowing->item;
        $itemBorrowing->update(['status' => 'rejected']);

        return redirect()->route('item_borrowings.index')
            ->with('swal_success', "Peminjaman <b>{$item->name}</b> oleh <b>{$itemBorrowing->borrower_name}</b> telah <b>Ditolak</b>.");
    }

    public function finish(ItemBorrowing $itemBorrowing)
    {
        if ($itemBorrowing->status !== 'approved') {
            return back()->with('swal_error', 'Hanya peminjaman berstatus Disetujui yang bisa diselesaikan.');
        }

        $item = $itemBorrowing->item;
        $item->increment('available_stock', $itemBorrowing->amount);
        $itemBorrowing->update(['status' => 'finished']);

        return redirect()->route('item_borrowings.index')
            ->with('swal_success', "Peminjaman <b>{$item->name}</b> dinyatakan <b>Selesai</b>. Stok kembali ditambah {$itemBorrowing->amount} unit.");
    }
}
