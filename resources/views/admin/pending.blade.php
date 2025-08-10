@extends('layouts.admin')

@section('content')
<div class="container">
    <h3>Daftar Calon Mentor</h3>
    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

    <table class="table">
        <thead><tr><th>Nama</th><th>Email</th><th>Aksi</th></tr></thead>
        <tbody>
            @foreach($mentors as $m)
            <tr>
                <td>{{ $m->name }}</td>
                <td>{{ $m->email }}</td>
                <td>
                    <form action="{{ route('mentor.approve',$m->id) }}" method="POST" style="display:inline">@csrf<button class="btn btn-success btn-sm">Setujui</button></form>
                    <form action="{{ route('mentor.reject',$m->id) }}" method="POST" style="display:inline">@csrf<button class="btn btn-danger btn-sm">Tolak</button></form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

