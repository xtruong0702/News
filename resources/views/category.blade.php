@extends('layouts.master')

@section('title', 'Chuyên mục: ' . $name)

@section('content')
<div class="container">
    <h1 class="mb-4 border-bottom pb-3">Chuyên mục: <span class="text-primary">{{ $name }}</span></h1>
    
    <div class="row">
        @forelse($posts as $post)
        <div class="col-md-4 mb-4" data-aos="fade-up">
            <div class="card card-news h-100 shadow-sm border-0 d-flex flex-column transition-hover">
                <a href="{{ url('/article/' . $post->slug) }}" class="overflow-hidden p-2 rounded-4">
                    <img src="{{ str_starts_with($post->image, 'http') ? $post->image : asset('storage/' . $post->image) }}" 
                         class="card-img-top rounded-3 transition-scale" 
                         alt="{{ $post->title }}" 
                         style="height: 220px; object-fit: cover; transition: transform 0.5s ease;">
                </a>
                <div class="card-body d-flex flex-column justify-content-between p-3">
                    <div>
                        <span class="badge bg-primary bg-opacity-10 text-primary mb-2 fw-bold px-3 py-1 rounded-pill small" style="font-size: 0.75rem;">
                            {{ strtoupper($post->category) }}
                        </span>
                        <h5 class="card-title fw-bold heading-font line-clamp-2 mt-1 mb-2">
                            <a href="{{ url('/article/' . $post->slug) }}" class="text-decoration-none text-dark transition-hover hover-text-primary">
                                {{ $post->title }}
                            </a>
                        </h5>
                        <p class="text-muted small line-clamp-3 mb-4">{{ $post->description }}</p>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center pt-2 border-top mt-auto">
                        <span class="text-muted small">
                            <i class="bi bi-clock me-1 text-primary"></i>{{ $post->created_at ? $post->created_at->format('d/m/Y') : 'Gần đây' }}
                        </span>
                        <a href="{{ url('/article/' . $post->slug) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1 fw-semibold transition-hover">
                            Xem chi tiết <i class="bi bi-arrow-right-short ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <p class="text-muted">Chưa có bài viết nào trong chuyên mục này.</p>
        </div>
        @endforelse
    </div>
</div>

{{-- Custom premium styles and animations local to Category page --}}
<style>
    .transition-scale {
        transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .card-news:hover .transition-scale {
        transform: scale(1.06);
    }
    .card-news {
        display: flex;
        flex-direction: column;
    }
    .card-news .card-body {
        flex-grow: 1;
    }
</style>

<!-- AOS (Animate on Scroll) Library -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (typeof AOS !== 'undefined') {
            AOS.init({ duration: 800, once: true });
        }
    });
</script>
@endsection