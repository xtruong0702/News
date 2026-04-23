@extends('layouts.master')

@section('title', 'Trang tin tức tổng hợp')

@section('content')
<div class="row">
    <div class="col-lg-8">
        
        {{-- Hero Section: Bài viết mới nhất --}}
        @if($posts->count() > 0)
        @php $hero = $posts->first(); @endphp
        <section class="hero-section mb-5">
            <div class="card card-news shadow-sm overflow-hidden border-0">
                <a href="{{ url('/article/'.$hero->slug) }}" class="text-decoration-none">
                    <div class="position-relative">
                        <img src="{{ $hero->image ?? 'https://picsum.photos/id/1/800/450' }}" class="card-img-top" alt="{{ $hero->title }}" style="height: 450px; object-fit: cover;">
                        <div class="position-absolute bottom-0 start-0 w-100 p-4" style="background: linear-gradient(transparent, rgba(0,0,0,0.8));">
                            <span class="badge bg-danger mb-2">MỚI NHẤT</span>
                            <h1 class="card-title h2 text-white fw-bold">{{ $hero->title }}</h1>
                            <p class="text-light opacity-75 mb-2">{{ Str::limit($hero->description, 120) }}</p>
                            <div class="d-flex align-items-center text-white-50">
                                <small class="fw-bold text-info">{{ $hero->category }}</small>
                                <span class="mx-2">•</span>
                                <small>{{ $hero->created_at->format('d/m/Y') }}</small>
                                <span class="mx-2">•</span>
                                <small><i class="bi bi-eye"></i> {{ number_format($hero->views) }}</small>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </section>
        @endif

        {{-- News Grid: Các bài viết tiếp theo --}}
        <h3 class="mb-4 border-start border-primary border-4 ps-3 fw-bold">Tin mới cập nhật</h3>
        <div class="row">
            @foreach($posts->skip(1) as $post)
            <div class="col-md-6 mb-4">
                <div class="card card-news h-100 shadow-sm border-0 transition-hover">
                    <a href="{{ url('/article/'.$post->slug) }}" class="text-decoration-none text-dark">
                        <div class="position-relative">
                            <img src="{{ $post->image ?? 'https://picsum.photos/id/10/400/225' }}" class="card-img-top" alt="{{ $post->title }}" style="height: 200px; object-fit: cover;">
                            <span class="badge bg-primary position-absolute top-0 start-0 m-2">{{ $post->category }}</span>
                        </div>
                        <div class="card-body">
                            <h2 class="h5 card-title fw-bold" style="line-height: 1.4;">{{ $post->title }}</h2>
                            <p class="card-text text-muted small">{{ Str::limit($post->description, 80) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                                <small class="text-muted"><i class="bi bi-eye"></i> {{ number_format($post->views) }}</small>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        @if($posts->count() == 0)
            <div class="alert alert-info">Chưa có bài viết nào được đăng.</div>
        @endif
    </div>

    <div class="col-lg-4">
        {{-- Trending Sidebar --}}
        <div class="card border-0 shadow-sm mb-4 bg-white">
            <div class="card-body">
                <h4 class="card-title mb-4 fw-bold">Trending 🔥</h4>
                <ul class="list-unstyled">
                    @foreach($trendingPosts as $key => $trend)
                    <li class="d-flex mb-3 align-items-start pb-3 {{ !$loop->last ? 'border-bottom border-light' : '' }}">
                        <span class="h4 text-primary me-3 fw-bold">0{{ $key + 1 }}</span>
                        <div>
                            <a href="{{ url('/article/'.$trend->slug) }}" class="text-decoration-none text-dark fw-bold small d-block mb-1 hover-primary">{{ $trend->title }}</a>
                            <small class="text-muted">{{ number_format($trend->views) }} lượt đọc</small>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- Categories --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h4 class="card-title mb-3 fw-bold">Chuyên mục</h4>
                <div class="d-flex flex-wrap gap-2">
                    @php
                        $categories = \App\Models\Post::select('category')->distinct()->get();
                    @endphp
                    @foreach($categories as $cat)
                        <a href="{{ url('/category/'.$cat->category) }}" class="btn btn-sm btn-outline-light text-dark border">{{ $cat->category }}</a>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Newsletter --}}
        <div class="card border-0 shadow-sm overflow-hidden text-white" style="background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-2">Đăng ký nhận tin</h5>
                <p class="small opacity-75">Nhận những tin tức quan trọng nhất vào email mỗi sáng.</p>
                <div class="input-group mb-2">
                    <input type="email" class="form-control border-0" placeholder="Email của bạn">
                    <button class="btn btn-dark">Gửi</button>
                </div>
                <small class="opacity-50" style="font-size: 10px;">Chúng tôi cam kết bảo mật thông tin của bạn.</small>
            </div>
        </div>
    </div>
</div>

<style>
    .transition-hover {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .transition-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .hover-primary:hover {
        color: #6366f1 !important;
    }
</style>
@endsection