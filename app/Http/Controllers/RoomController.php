<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $rooms = Room::with('category')->paginate(10);
        } elseif ($user->role === 'sarpras') {
            $rooms = Room::where('category_id', 1)->with('category')->paginate(10);
        } else {
            $rooms = Room::where('category_id', $user->category_id)->with('category')->paginate(10);
        }

        return view('rooms.index', compact('rooms'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('rooms.create', compact('categories'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect('/rooms')->with('error', 'Hanya admin yang dapat menambah ruangan!');
        }

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('rooms', 'public');
            $validated['image'] = $path;
        }

        Room::create($validated);

        return redirect('/rooms')->with('success', 'Ruangan berhasil ditambahkan!');
    }


    public function show(Room $room)
    {
        return view('rooms.show', compact('room'));
    }

    public function edit(Room $room)
    {
        $categories = Category::all();
        return view('rooms.edit', compact('room', 'categories'));
    }

    public function update(Request $request, Room $room)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect('/rooms')->with('error', 'Hanya admin yang dapat mengubah ruangan!');
        }

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($room->image) {
                Storage::disk('public')->delete($room->image);
            }
            
            $path = $request->file('image')->store('rooms', 'public');
            $validated['image'] = $path;
        }

        $room->update($validated);

        return redirect('/rooms')->with('success', 'Ruangan berhasil diperbarui!');
    }


    public function destroy(Room $room)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect('/rooms')->with('error', 'Hanya admin yang dapat menghapus ruangan!');
        }

        if ($room->image) {
            Storage::disk('public')->delete($room->image);
        }

        $room->delete();
        return redirect('/rooms')->with('success', 'Ruangan berhasil dihapus!');
    }

}
