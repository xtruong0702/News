@extends('layouts.master')

@section('title', 'Cổng thông tin đa phương tiện News 24H')

@section('content')
<!-- Google Fonts & Libraries -->
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

{{-- 1. BREAKING NEWS TICKER --}}
<div class="breaking-news-container mb-4 shadow-sm" data-aos="fade-down">
    <div class="d-flex align-items-center">
        <div class="breaking-title px-4 py-2 text-white fw-bold">TIN NÓNG</div>
        <div class="ticker-content flex-grow-1 overflow-hidden">
            <marquee behavior="scroll" direction="left" onmouseover="this.stop();" onmouseout="this.start();">
                @foreach($posts->take(5) as $p)
                    <a href="{{ url('/article/'.$p->slug) }}" class="text-decoration-none text-dark me-5 small fw-semibold">
                        <span class="text-danger">•</span> {{ $p->title }}
                    </a>
                @endforeach
            </marquee>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-9">
        {{-- 2. TRIPLE HERO SECTION --}}
        @if($posts->count() >= 3)
        @php 
            $hero = $posts[0];
            $subHero1 = $posts[1];
            $subHero2 = $posts[2];
        @endphp
        <div class="row g-3 mb-5">
            <div class="col-lg-8" data-aos="fade-right">
                <div class="card border-0 overflow-hidden shadow-lg main-hero-portal h-100 rounded-4">
                    <a href="{{ url('/article/'.$hero->slug) }}" class="text-decoration-none">
                        <div class="position-relative h-100">
                            <img src="{{ $hero->image ?? 'https://picsum.photos/id/10/800/600' }}" class="w-100 h-100 object-fit-cover" alt="{{ $hero->title }}" style="min-height: 520px;">
                            <div class="position-absolute bottom-0 start-0 w-100 p-4 p-md-5 hero-gradient-overlay">
                                <span class="badge bg-warning text-dark mb-3 px-3 py-2 rounded-pill fw-bold">CHỦ ĐIỂM HÔM NAY</span>
                                <h1 class="display-5 fw-bold text-white mb-3 lh-sm main-title-font">{{ $hero->title }}</h1>
                                <p class="text-white-50 mb-3 d-none d-md-block">{{ Str::limit($hero->description, 150) }}</p>
                                <div class="d-flex align-items-center text-white-50 small">
                                    <span class="fw-bold text-info">{{ $hero->category }}</span>
                                    <span class="mx-3">/</span>
                                    <span>{{ $hero->created_at->format('d M, Y') }}</span>
                                    <span class="mx-3">/</span>
                                    <span><i class="bi bi-eye"></i> {{ number_format($hero->views) }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="row g-3 h-100">
                    <div class="col-12" data-aos="fade-left" data-aos-delay="100">
                        <div class="card border-0 overflow-hidden shadow-sm sub-hero-portal rounded-4">
                            <a href="{{ url('/article/'.$subHero1->slug) }}" class="text-decoration-none text-white">
                                <div class="position-relative">
                                    <img src="{{ $subHero1->image ?? 'https://picsum.photos/id/20/400/300' }}" class="w-100" alt="{{ $subHero1->title }}" style="height: 252px; object-fit: cover;">
                                    <div class="position-absolute bottom-0 start-0 w-100 p-3 hero-gradient-overlay-small">
                                        <h5 class="fw-bold mb-1">{{ Str::limit($subHero1->title, 60) }}</h5>
                                        <small class="text-warning fw-bold">{{ $subHero1->category }}</small>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-12" data-aos="fade-left" data-aos-delay="200">
                        <div class="card border-0 overflow-hidden shadow-sm sub-hero-portal rounded-4">
                            <a href="{{ url('/article/'.$subHero2->slug) }}" class="text-decoration-none text-white">
                                <div class="position-relative">
                                    <img src="{{ $subHero2->image ?? 'https://picsum.photos/id/30/400/300' }}" class="w-100" alt="{{ $subHero2->title }}" style="height: 252px; object-fit: cover;">
                                    <div class="position-absolute bottom-0 start-0 w-100 p-3 hero-gradient-overlay-small">
                                        <h5 class="fw-bold mb-1">{{ Str::limit($subHero2->title, 60) }}</h5>
                                        <small class="text-warning fw-bold">{{ $subHero2->category }}</small>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- 3. CATEGORY SECTION: THỜI TRANG & LÀM ĐẸP (PHONG CÁCH TẠP CHÍ) --}}
        <div class="mt-5 mb-5" data-aos="fade-up">
            <div class="d-flex align-items-center mb-4">
                <h2 class="section-title-premium m-0">Thời trang & Làm đẹp</h2>
                <div class="flex-grow-1 ms-4 border-bottom border-light"></div>
            </div>
            <div class="row g-4">
                @php
                    $beautyPosts = \App\Models\Post::whereIn('category', ['Thời trang', 'Làm đẹp'])->latest()->take(3)->get();
                @endphp
                @foreach($beautyPosts as $bp)
                <div class="col-md-4">
                    <div class="magazine-card">
                        <a href="{{ url('/article/'.$bp->slug) }}" class="text-decoration-none text-dark">
                            <div class="overflow-hidden rounded-0 mb-3 shadow-sm">
                                <img src="{{ $bp->image ?? 'https://picsum.photos/id/100/400/500' }}" class="img-fluid w-100 magazine-img" alt="{{ $bp->title }}" style="height: 400px; object-fit: cover;">
                            </div>
                            <small class="text-uppercase text-muted fw-bold ls-2">{{ $bp->category }}</small>
                            <h4 class="mt-2 fw-bold serif-font">{{ $bp->title }}</h4>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- 4. MAIN NEWS FEED --}}
        <div class="row mt-5">
            <div class="col-12 mb-4 d-flex align-items-center">
                <h3 class="fw-bold m-0 section-title-portal">Tin tức mới nhất</h3>
            </div>
            @foreach($posts->skip(3) as $post)
            <div class="col-12 mb-4" data-aos="fade-up">
                <div class="card border-0 bg-transparent horizontal-news-card">
                    <div class="row g-0 align-items-center">
                        <div class="col-md-4">
                            <div class="overflow-hidden rounded-4">
                                <a href="{{ url('/article/'.$post->slug) }}">
                                    <img src="{{ $post->image ?? 'https://picsum.photos/id/150/400/250' }}" class="img-fluid w-100 transition-scale" alt="{{ $post->title }}" style="height: 200px; object-fit: cover;">
                                </a>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body ps-md-4 py-0">
                                <a href="{{ url('/category/'.$post->category) }}" class="text-decoration-none"><span class="text-primary fw-bold x-small">{{ strtoupper($post->category) }}</span></a>
                                <h3 class="h4 fw-bold mt-1"><a href="{{ url('/article/'.$post->slug) }}" class="text-decoration-none text-dark card-hover-title">{{ $post->title }}</a></h3>
                                <p class="text-muted small">{{ Str::limit($post->description, 160) }}</p>
                                <div class="d-flex align-items-center text-muted x-small">
                                    <span class="me-3"><i class="bi bi-clock me-1"></i>{{ $post->created_at->diffForHumans() }}</span>
                                    <span><i class="bi bi-chat-dots me-1"></i>{{ $post->comments->count() }} bình luận</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $posts->links('pagination::bootstrap-5') }}
        </div>
    </div>

    {{-- SIDEBAR PORTAL --}}
    <div class="col-lg-3">
        {{-- Widget: Thời gian & Thời tiết --}}
        <div class="card border-0 shadow-sm mb-4 bg-primary text-white rounded-4 overflow-hidden">
            <div class="card-body p-4 text-center">
                <div class="h5 mb-0 fw-bold">{{ date('l, d F') }}</div>
                <div class="display-4 fw-bold my-2">28°C</div>
                <div class="small opacity-75">TP. Hồ Chí Minh, VN</div>
                <div class="mt-3 x-small bg-white bg-opacity-25 py-1 rounded-pill">Dự báo: Có mây, nắng nhẹ</div>
            </div>
        </div>

        {{-- Widget: Trending 🔥 --}}
        <div class="card border-0 shadow-sm mb-4 rounded-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4 border-bottom pb-2">XU HƯỚNG 🔥</h5>
                @foreach($trendingPosts as $key => $trend)
                <div class="mb-4 d-flex align-items-start">
                    <div class="trending-rank me-3">{{ $key+1 }}</div>
                    <div>
                        <a href="{{ url('/article/'.$trend->slug) }}" class="text-decoration-none text-dark fw-bold small lh-sm d-block mb-1 trending-title-link">{{ $trend->title }}</a>
                        <div class="x-small text-muted">{{ number_format($trend->views) }} lượt đọc</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Widget: Thảo luận mới --}}
        <div class="card border-0 shadow-sm mb-4 rounded-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4 border-bottom pb-2">THẢO LUẬN 💬</h5>
                @php
                    $recentComments = \App\Models\Comment::with('user', 'post')->latest()->take(3)->get();
                @endphp
                @foreach($recentComments as $comm)
                <div class="mb-3 pb-3 border-bottom border-light last-no-border">
                    <div class="d-flex align-items-center mb-2">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($comm->user->name) }}&background=6366f1&color=fff" class="rounded-circle me-2" width="20" height="20">
                        <span class="fw-bold x-small">{{ $comm->user->name }}</span>
                    </div>
                    <a href="{{ url('/article/'.$comm->post->slug) }}" class="text-decoration-none">
                        <p class="text-muted x-small mb-1 font-italic">"{{ Str::limit($comm->content, 60) }}"</p>
                        <div class="x-small text-primary fw-semibold">Trong: {{ Str::limit($comm->post->title, 30) }}</div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Widget: Scan App --}}
        <div class="card border-0 shadow-lg text-center p-4 rounded-4" style="background: #1e1e1e;">
            <h6 class="text-white fw-bold mb-3">TẢI APP NEWS 24H</h6>
            <div class="bg-white p-2 d-inline-block rounded-3 mb-3">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=https://news24h.vn" width="100">
            </div>
            <p class="text-white-50 x-small px-2">Quét mã để đọc tin tức nhanh nhất trên điện thoại của bạn.</p>
        </div>
    </div>
</div>

<style>
    body { font-family: 'Outfit', sans-serif; background-color: #f5f7f9; }
    .main-title-font { font-family: 'Playfair Display', serif; }
    .serif-font { font-family: 'Playfair Display', serif; }
    .x-small { font-size: 0.75rem; }
    .ls-2 { letter-spacing: 2px; }

    /* Breaking News */
    .breaking-news-container { background: white; border-radius: 50px; overflow: hidden; height: 45px; }
    .breaking-title { background: #dc3545; height: 100%; display: flex; align-items: center; }
    
    /* Hero Portal */
    .hero-gradient-overlay { background: linear-gradient(transparent, rgba(0,0,0,0.9)); transition: 0.5s; }
    .hero-gradient-overlay-small { background: linear-gradient(transparent, rgba(0,0,0,0.85)); }
    .main-hero-portal img { transition: 1s; }
    .main-hero-portal:hover img { transform: scale(1.05); }

    /* Magazine Card */
    .magazine-img { transition: 0.8s; }
    .magazine-card:hover .magazine-img { transform: translateY(-10px); }
    .magazine-card h4 { transition: 0.3s; line-height: 1.3; }
    .magazine-card:hover h4 { color: #6366f1; }

    /* Horizontal Card */
    .horizontal-news-card .transition-scale { transition: 0.6s; }
    .horizontal-news-card:hover .transition-scale { transform: scale(1.1); }
    .card-hover-title { transition: 0.3s; }
    .horizontal-news-card:hover .card-hover-title { color: #6366f1; }

    /* Sidebar Widgets */
    .trending-rank { font-size: 1.8rem; font-weight: 900; color: #e9ecef; line-height: 1; min-width: 35px; }
    .trending-title-link:hover { color: #6366f1 !important; }
    .last-no-border:last-child { border: 0 !important; }

    .section-title-premium { font-family: 'Playfair Display', serif; font-size: 2.2rem; font-weight: 700; color: #1a1a1a; }
    .section-title-portal { position: relative; padding-bottom: 15px; }
    .section-title-portal::after { content: ""; position: absolute; bottom: 0; left: 0; width: 50px; height: 5px; background: #6366f1; }
</style>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ duration: 1000, once: true });
</script>
@endsection