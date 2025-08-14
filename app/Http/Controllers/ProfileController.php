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

class ProfileController extends Controller
{
    /**
     * Menampilkan dashboard profile.
     */
    public function index(): View
    {
        return view('user.profile', [
            'user' => Auth::user(),
        ]);
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
     * Update profil user.
     */
    public function update(ProfileUpdateRequest $request)
    {
        $user = $request->user();

        $validatedData = $request->validated();

        // Handle skills array
        if (isset($validatedData['skills']) && is_array($validatedData['skills'])) {
            $validatedData['skills'] = json_encode($validatedData['skills']);
        }

        // Upload foto profil
        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::delete($user->photo);
            }
            $validatedData['photo'] = $request->file('photo')->store('profile-photos', 'public');
        }

        $user->update($validatedData);

        return Redirect::route('profile.index')->with('status', 'profile-updated');
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
}