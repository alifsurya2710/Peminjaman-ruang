<?php

namespace App\Http\Controllers;

use App\Models\FloorPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class FloorPlanController extends Controller
{
    public function index()
    {
        $floorPlans = FloorPlan::latest()->get();
        return view('floor-plans.index', compact('floorPlans'));
    }

    public function create()
    {
        if (Auth::user()->role !== 'admin') abort(403);
        return view('floor-plans.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') abort(403);

        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|file|mimes:jpeg,png,jpg,pdf|max:10240',
            'description' => 'nullable|string',
        ]);

        $imagePath = $request->file('image')->store('floor-plans', 'public');

        FloorPlan::create([
            'title' => $request->title,
            'image' => $imagePath,
            'description' => $request->description,
        ]);

        return redirect()->route('floor-plans.index')->with('success', 'Denah berhasil ditambahkan!');
    }

    public function edit(FloorPlan $floorPlan)
    {
        if (Auth::user()->role !== 'admin') abort(403);
        return view('floor-plans.edit', compact('floorPlan'));
    }

    public function update(Request $request, FloorPlan $floorPlan)
    {
        if (Auth::user()->role !== 'admin') abort(403);

        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:10240',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($floorPlan->image);
            $floorPlan->image = $request->file('image')->store('floor-plans', 'public');
        }

        $floorPlan->title = $request->title;
        $floorPlan->description = $request->description;
        $floorPlan->save();

        return redirect()->route('floor-plans.index')->with('success', 'Denah berhasil diperbarui!');
    }

    public function destroy(FloorPlan $floorPlan)
    {
        if (Auth::user()->role !== 'admin') abort(403);

        Storage::disk('public')->delete($floorPlan->image);
        $floorPlan->delete();

        return redirect()->route('floor-plans.index')->with('success', 'Denah berhasil dihapus!');
    }

    public function download(FloorPlan $floorPlan)
    {
        return Storage::disk('public')->download($floorPlan->image, $floorPlan->title . '.' . pathinfo($floorPlan->image, PATHINFO_EXTENSION));
    }
}
