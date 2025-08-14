<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MaterialController extends Controller
{
    // Menampilkan form tambah materi
  public function create(ClassModel $class)
{
    if ($class->mentor_id !== auth()->id()) {
        abort(403);
    }

    return view('materials.create', compact('class'));
}


    // Menyimpan materi baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'required|string',
            'class_id' => 'required|exists:classes,id',
            'is_published' => 'boolean',
        ]);

        // Pastikan mentor hanya bisa buat materi untuk kelasnya sendiri
        $class = ClassModel::findOrFail($request->class_id);
        if ($class->mentor_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $material = Material::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'content' => $validated['content'],
            'class_id' => $validated['class_id'],
            'is_published' => $validated['is_published'] ?? false,
        ]);

        return redirect()->route('classes.show', $class->id)
            ->with('success', 'Materi berhasil ditambahkan!');
    }

    // Menampilkan detail materi
    public function show(Material $material)
    {
        // Pastikan user memiliki akses ke kelas ini
        // if (!auth()->user()->canAccessMaterial($material)) {
        //     abort(403, 'Unauthorized action.');
        // }

        return view('materials.show', compact('material'));
    }

    // Form edit materi
    public function edit(Material $material)
    {
        // Pastikan hanya mentor pemilik kelas yang bisa mengedit
        if ($material->class->mentor_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('materials.edit', compact('material'));
    }

    // Update materi
    public function update(Request $request, Material $material)
    {
        // Pastikan hanya mentor pemilik kelas yang bisa mengupdate
        if ($material->class->mentor_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'required|string',
            'is_published' => 'boolean',
        ]);

        $material->update([
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->input('content'),
            'is_published' => $request->is_published ?? false,
        ]);

        return redirect()->route('classes.show', $material->class_id)
            ->with('success', 'Materi berhasil diperbarui!');
    }

    // Hapus materi
    public function destroy(Material $material)
    {
        // Pastikan hanya mentor pemilik kelas yang bisa menghapus
        if ($material->class->mentor_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $material->delete();

        return redirect()->route('classes.show', $material->class_id)
            ->with('success', 'Materi berhasil dihapus!');
    }
}
