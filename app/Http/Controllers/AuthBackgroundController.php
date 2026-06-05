<?php

namespace App\Http\Controllers;

use App\Models\AuthBackground;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AuthBackgroundController extends Controller
{

    public function index()
    {
        $backgrounds = AuthBackground::latest()->get();
        return view('auth-backgrounds.index', compact('backgrounds'));
    }

    public function create()
    {
        return view('auth-backgrounds.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:10240',
            'is_active_login' => 'nullable',
            'is_active_forgot_password' => 'nullable',
        ]);

        $imagePath = $request->file('image')->store('auth-backgrounds', 'public');

        $isActiveLogin = $request->has('is_active_login');
        $isActiveForgotPassword = $request->has('is_active_forgot_password');

        if ($isActiveLogin) {
            AuthBackground::where('is_active_login', true)->update(['is_active_login' => false]);
        }

        if ($isActiveForgotPassword) {
            AuthBackground::where('is_active_forgot_password', true)->update(['is_active_forgot_password' => false]);
        }

        AuthBackground::create([
            'name' => $request->name,
            'image' => $imagePath,
            'is_active_login' => $isActiveLogin,
            'is_active_forgot_password' => $isActiveForgotPassword,
        ]);

        return redirect()->route('auth-backgrounds.index')->with('success', 'Background berhasil ditambahkan!');
    }

    public function edit(AuthBackground $authBackground)
    {
        return view('auth-backgrounds.edit', compact('authBackground'));
    }

    public function update(Request $request, AuthBackground $authBackground)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'is_active_login' => 'nullable',
            'is_active_forgot_password' => 'nullable',
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($authBackground->image);
            $authBackground->image = $request->file('image')->store('auth-backgrounds', 'public');
        }

        $isActiveLogin = $request->has('is_active_login');
        $isActiveForgotPassword = $request->has('is_active_forgot_password');

        if ($isActiveLogin) {
            AuthBackground::where('is_active_login', true)->update(['is_active_login' => false]);
            $authBackground->is_active_login = true;
        } else {
            $authBackground->is_active_login = false;
        }

        if ($isActiveForgotPassword) {
            AuthBackground::where('is_active_forgot_password', true)->update(['is_active_forgot_password' => false]);
            $authBackground->is_active_forgot_password = true;
        } else {
            $authBackground->is_active_forgot_password = false;
        }

        $authBackground->name = $request->name;
        $authBackground->save();

        return redirect()->route('auth-backgrounds.index')->with('success', 'Background berhasil diperbarui!');
    }

    public function destroy(AuthBackground $authBackground)
    {
        Storage::disk('public')->delete($authBackground->image);
        $authBackground->delete();

        return redirect()->route('auth-backgrounds.index')->with('success', 'Background berhasil dihapus!');
    }

    public function activateLogin(AuthBackground $authBackground)
    {
        AuthBackground::where('is_active_login', true)->update(['is_active_login' => false]);
        $authBackground->is_active_login = true;
        $authBackground->save();

        return redirect()->route('auth-backgrounds.index')->with('success', 'Background login berhasil diaktifkan!');
    }

    public function activateForgotPassword(AuthBackground $authBackground)
    {
        AuthBackground::where('is_active_forgot_password', true)->update(['is_active_forgot_password' => false]);
        $authBackground->is_active_forgot_password = true;
        $authBackground->save();

        return redirect()->route('auth-backgrounds.index')->with('success', 'Background lupa password berhasil diaktifkan!');
    }
}
