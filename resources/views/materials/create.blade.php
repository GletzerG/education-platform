@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header">
                        <h3>Tambah Materi Baru untuk Kelas: {{ $class->name }}</h3>
                    </div>
                    <div class="card-body">
                        <!-- Tambahkan ini untuk menampilkan error validasi -->
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Tambahkan ini untuk menampilkan flash message -->
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('materials.store') }}" method="POST">
                            @csrf
                            <!-- Perbaikan: ganti mentor_id dengan class_id -->
                            <input type="hidden" name="class_id" value="{{ $class->id }}">

                            <div class="mb-3">
                                <label for="title" class="form-label">Judul Materi</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    id="title" name="title" value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi Singkat</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                    rows="2">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label">Konten Materi</label>
                                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="10"
                                    required>{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 form-check">
                                <!-- Tambahkan value="1" dan ubah name menjadi is_published dengan nilai default -->
                                <input type="hidden" name="is_published" value="0"> <!-- Nilai default false -->
                                <input type="checkbox" class="form-check-input @error('is_published') is-invalid @enderror"
                                    id="is_published" name="is_published" value="1"
                                    {{ old('is_published', 0) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_published">Publikasikan materi</label>
                                @error('is_published')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan Materi</button>
                            <a href="{{ route('classes.show', $class->id) }}" class="btn btn-secondary">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
