@extends('layouts.master')

@section('title', 'Kết quả tìm kiếm: ' . $query)

@section('content')
<div class="container">
    <div class="mb-5">
        <h2 class="fw-bold border-bottom pb-3">Kết quả tìm kiếm cho: <span class="text-primary">"{{ $query }}"</span></h2>
        <p class="text-muted small">Tìm thấy {{ $posts->total() }} bài viết phù hợp.</p>
    </div>
    
    <div class="row">
        @forelse($posts as $post)
        <div class="col-md-4 mb-4">
            <div class="card card-news h-100 shadow-sm border-0 rounded-4 overflow-hidden">
                <a href="{{ url('/article/' . $post->slug) }}">
                    <img src="{{ $post->image ? (str_starts_with($post->image, 'http') ? $post->image : asset('storage/' . $post->image)) : 'https://picsum.photos/id/150/400/250' }}" class="card-img-top" alt="{{ $post->title }}" style="height: 200px; object-fit: cover;">
                </a>
                <div class="card-body p-4">
                    <div class="mb-2">
                        <span class="badge bg-light text-primary rounded-pill px-3">{{ $post->category }}</span>
                    </div>
                    <h5 class="card-title fw-bold">
                        <a href="{{ url('/article/' . $post->slug) }}" class="text-decoration-none text-dark hover-primary">
                            {{ $post->title }}
                        </a>
                    </h5>
                    <p class="text-muted small mb-0">{{ Str::limit($post->description, 100) }}</p>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="mb-4">
                <i class="bi bi-search text-muted" style="font-size: 4rem; opacity: 0.3;"></i>
            </div>
            <h3 class="fw-bold">Rất tiếc, không tìm thấy kết quả</h3>
            <p class="text-muted">Hãy thử lại với từ khóa khác hoặc kiểm tra lại lỗi chính tả.</p>
            <a href="/" class="btn btn-primary rounded-pill px-4 mt-3">Quay lại Trang chủ</a>
        </div>
        @endforelse
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $posts->appends(['query' => $query])->links('pagination::bootstrap-5') }}
    </div>
</div>

<style>
    .hover-primary:hover { color: #6366f1 !important; }
    .card-news { transition: transform 0.3s, box-shadow 0.3s; }
    .card-news:hover { transform: translateY(-10px); box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important; }
</style>
@endsection
