<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MentorController extends Controller
{
    public function pending()
    {
        $mentors = User::where('role', 'mentor')->where('is_verified', false)->get();
        return view('admin.pending', compact('mentors'));
    }


    public function approve(User $user)
    {
        if ($user->role !== 'mentor') {
            return back()->with('error', 'User bukan mentor.');
        }

        $user->update(['is_verified' => true]);

        // 🔹 Pastikan role di Spatie juga ada
        if (!$user->hasRole('mentor')) {
            $user->assignRole('mentor');
        }

        return back()->with('success', 'Mentor berhasil diverifikasi.');
    }


    public function reject(User $user)
    {
        if ($user->role !== 'mentor') {
            return back()->with('error', 'User bukan mentor.');
        }
        // Pilihan: ubah role jadi siswa atau hapus
        $user->update(['role' => 'siswa', 'is_verified' => true]);
        return back()->with('success', 'Permintaan mentor ditolak dan diubah menjadi siswa.');
    }
}
