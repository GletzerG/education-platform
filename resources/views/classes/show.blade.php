@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="mb-0">{{ $class->name }}</h2>
                        <div>
                            <a href="{{ route('classes.index') }}" class="btn btn-outline-secondary me-2">
                                Back to All Classes
                            </a>
                            @if($class->mentor_id === auth()->id())
                                <a href="{{ route('classes.edit', $class->id) }}" class="btn btn-outline-warning me-2">
                                    Edit Class
                                </a>
                                <form action="{{ route('classes.destroy', $class->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger"
                                            onclick="return confirm('Are you sure you want to delete this class?')">
                                        Delete Class
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            @if($class->description)
                                <h5>Description</h5>
                                <p class="lead">{{ $class->description }}</p>
                            @else
                                <p class="text-muted fst-italic">No description provided.</p>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Class Information</h6>
                                    <p class="card-text">
                                        <strong>Mentor:</strong><br>
                                        <i class="fas fa-user me-1"></i> {{ $class->mentor->name ?? 'Unknown' }}
                                    </p>
                                    <p class="card-text">
                                        <strong>Created:</strong><br>
                                        <i class="fas fa-calendar me-1"></i> {{ $class->created_at->format('d M Y') }}
                                    </p>
                                    <p class="card-text">
                                        <strong>Last Updated:</strong><br>
                                        <i class="fas fa-clock me-1"></i> {{ $class->updated_at->format('d M Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
