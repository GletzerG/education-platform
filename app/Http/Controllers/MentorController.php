<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MentorController extends Controller
{
    public function pending(Request $request)
    {
        if ($request->ajax()) {
            $mentors = User::where('role', 'mentor')
                ->where('is_verified', false)
                ->select(['id', 'name', 'email','created_at']);

            return DataTables::of($mentors)
                ->addColumn('created_at', function ($m) {
                    // Pastikan locale di AppServiceProvider: Carbon::setLocale('id');
                    return $m->created_at->translatedFormat('d F Y H:i'); // contoh: 11 Agustus 2025 14:45
                })
                ->addColumn('aksi', function ($m) {
                    $approveBtn = '<form action="' . route('mentor.approve', $m->id) . '" method="POST" style="display:inline">' . csrf_field() . '<button class="btn btn-success btn-sm">Setujui</button></form>';
                    $rejectBtn  = '<form action="' . route('mentor.reject', $m->id) . '" method="POST" style="display:inline">' . csrf_field() . '<button class="btn btn-danger btn-sm">Tolak</button></form>';
                    return $approveBtn . ' ' . $rejectBtn;
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }

        return view('admin.pending');
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

        // Hapus role mentor dari Spatie
        if ($user->hasRole('mentor')) {
            $user->removeRole('mentor');
        }

        // Assign role siswa di Spatie
        if (!$user->hasRole('siswa')) {
            $user->assignRole('siswa');
        }

        // Update di tabel users
        $user->update([
            'role' => 'siswa',
            'is_verified' => true
        ]);

        return back()->with('success', 'Permintaan mentor ditolak dan diubah menjadi siswa.');
    }
}
