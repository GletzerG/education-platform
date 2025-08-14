@extends('layouts.app')

@section('content')
<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
    }

    .main-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 2rem 15px;
    }

    .material-detail-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        overflow: hidden;
        border: none;
    }

    .material-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem;
    }

    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 2rem;
    }

    .header-info {
        flex: 1;
    }

    .material-title {
        font-size: 2.2rem;
        font-weight: 700;
        margin: 0 0 1rem 0;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        line-height: 1.3;
    }

    .material-subtitle {
        font-size: 1.1rem;
        color: rgba(255,255,255,0.9);
        margin: 0;
        font-weight: 400;
    }

    .btn-back {
        background: white;
        color: #667eea;
        border: none;
        padding: 12px 20px;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
    }

    .btn-back:hover {
        background: #f8f9ff;
        color: #5a67d8;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(255,255,255,0.3);
    }

    .material-body {
        padding: 2.5rem;
    }

    .description-section {
        background: #f8fafc;
        border-left: 4px solid #667eea;
        padding: 1.5rem;
        margin-bottom: 2rem;
        border-radius: 0 8px 8px 0;
    }

    .description-text {
        font-size: 1.1rem;
        color: #4a5568;
        margin: 0;
        line-height: 1.7;
        font-style: italic;
    }

    .content-section {
        background: white;
        padding: 2rem;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        margin-bottom: 2rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .content-header {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f1f5f9;
    }

    .content-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
    }

    .content-title {
        font-size: 1.4rem;
        font-weight: 600;
        color: #2d3748;
        margin: 0;
    }

    .material-content {
        line-height: 1.8;
        color: #4a5568;
        font-size: 1rem;
    }

    .material-content h1,
    .material-content h2,
    .material-content h3,
    .material-content h4 {
        color: #2d3748;
        margin-top: 2rem;
        margin-bottom: 1rem;
        font-weight: 600;
    }

    .material-content h1 { font-size: 1.8rem; }
    .material-content h2 { font-size: 1.5rem; }
    .material-content h3 { font-size: 1.3rem; }
    .material-content h4 { font-size: 1.1rem; }

    .material-content p {
        margin-bottom: 1.2rem;
        text-align: justify;
    }

    .material-content ul,
    .material-content ol {
        padding-left: 1.5rem;
        margin-bottom: 1.2rem;
    }

    .material-content li {
        margin-bottom: 0.5rem;
    }

    .material-content blockquote {
        border-left: 4px solid #667eea;
        background: #f8fafc;
        padding: 1rem 1.5rem;
        margin: 1.5rem 0;
        font-style: italic;
        border-radius: 0 8px 8px 0;
    }

    .material-content code {
        background: #f1f5f9;
        padding: 2px 6px;
        border-radius: 4px;
        font-family: 'Courier New', monospace;
        color: #e53e3e;
        font-size: 0.9rem;
    }

    .material-content pre {
        background: #1a202c;
        color: #e2e8f0;
        padding: 1.5rem;
        border-radius: 8px;
        overflow-x: auto;
        margin: 1.5rem 0;
    }

    .material-content pre code {
        background: none;
        color: inherit;
        padding: 0;
    }

    .info-footer {
        background: #f8fafc;
        padding: 2rem;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 1rem;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .info-icon {
        width: 35px;
        height: 35px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.9rem;
        flex-shrink: 0;
    }

    .info-content {
        flex: 1;
    }

    .info-label {
        font-size: 0.85rem;
        color: #718096;
        font-weight: 500;
        margin: 0 0 4px 0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-text {
        font-size: 1rem;
        color: #2d3748;
        font-weight: 600;
        margin: 0;
    }

    @media (max-width: 768px) {
        .header-content {
            flex-direction: column;
            gap: 1.5rem;
            align-items: stretch;
        }

        .btn-back {
            align-self: flex-start;
        }

        .material-title {
            font-size: 1.8rem;
        }

        .material-body {
            padding: 1.5rem;
        }

        .content-section {
            padding: 1.5rem;
        }

        .info-footer {
            padding: 1.5rem;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 576px) {
        .main-container {
            padding: 1rem;
        }

        .material-header {
            padding: 1.5rem;
        }

        .material-body {
            padding: 1rem;
        }

        .content-section {
            padding: 1rem;
        }

        .description-section {
            padding: 1rem;
        }

        .material-title {
            font-size: 1.5rem;
        }

        .material-content {
            font-size: 0.95rem;
        }
    }
</style>

<div class="main-container">
    <div class="row">
        <div class="col-12">
            <div class="material-detail-card">
                <!-- Header Section -->
                <div class="material-header">
                    <div class="header-content">
                        <div class="header-info">
                            <h1 class="material-title">{{ $material->title }}</h1>
                            <p class="material-subtitle">Kelas: {{ $material->class->name }}</p>
                        </div>
                        <a href="{{ route('classes.learn', $material->class_id) }}" class="btn-back">
                            <i class="fas fa-arrow-left"></i>
                            Kembali ke Daftar Materi
                        </a>
                    </div>
                </div>

                <!-- Body Section -->
                <div class="material-body">
                    <!-- Description Section -->
                    @if($material->description)
                        <div class="description-section">
                            <p class="description-text">{{ $material->description }}</p>
                        </div>
                    @endif

                    <!-- Content Section -->
                    <div class="content-section">
                        <div class="content-header">
                            <div class="content-icon">
                                <i class="fas fa-file-alt"></i>
                            </div>
                            <h2 class="content-title">Materi Pembelajaran</h2>
                        </div>

                        <div class="material-content">
                            {!! $material->content !!}
                        </div>
                    </div>

                    <!-- Info Footer -->
                    <div class="info-footer">
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                </div>
                                <div class="info-content">
                                    <p class="info-label">Mentor</p>
                                    <p class="info-text">{{ $material->class->mentor->name }}</p>
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-calendar-plus"></i>
                                </div>
                                <div class="info-content">
                                    <p class="info-label">Dibuat</p>
                                    <p class="info-text">{{ $material->created_at->format('j M Y') }}</p>
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="info-content">
                                    <p class="info-label">Terakhir Update</p>
                                    <p class="info-text">{{ $material->updated_at->format('j M Y H:i') }}</p>
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
