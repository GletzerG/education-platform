<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Activity;

class ProfileController extends Controller
{
    /**
     * Dashboard profile user.
     */
    public function index(): View
    {
        $user = Auth::user();

        $stats = [
            'projects' => 24,
            'tasks' => 156,
            'hours' => 1245,
            'achievements' => 12
        ];

        $activities = $user->activities()
            ->latest()
            ->limit(10)
            ->get();

        return view('user.profile', compact('user', 'stats', 'activities'));
    }

    /**
     * Menampilkan form edit profile.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update profil user (data + avatar).
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
            'location' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:500',
            'skills' => 'nullable|array',
            'skills.*' => 'string|max:50',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $user = Auth::user();

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::delete('public/' . $user->avatar);
            }
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        // Prepare data update
        $updateData = $request->only(['name', 'email', 'phone', 'location', 'bio']);

        if ($request->has('skills') && is_array($request->skills)) {
            $updateData['skills'] = json_encode($request->skills);
        } elseif ($request->has('skills') && is_null($request->skills)) {
            $updateData['skills'] = null;
        }

        $user->update($updateData);

        Activity::create([
            'user_id' => $user->id,
            'action' => 'Updated profile information',
            'type' => 'info'
        ]);

        return redirect()->route('profile.index')
            ->with('success', 'Profile berhasil diupdate!');
    }

    /**
     * Update password user.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('status', 'password-updated');
    }

    /**
     * Hapus akun user.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Upload avatar saja (API/AJAX).
     */
    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated'
            ], 401);
        }

        if ($user->avatar) {
            Storage::delete('public/' . $user->avatar);
        }

        $avatarPath = $request->file('avatar')->store('avatars', 'public');
        $user->update(['avatar' => $avatarPath]);

        Activity::create([
            'user_id' => $user->id,
            'action' => 'Updated profile picture',
            'type' => 'info'
        ]);

        return response()->json([
            'success' => true,
            'avatar_url' => asset('storage/' . $avatarPath)
        ]);
    }
}
