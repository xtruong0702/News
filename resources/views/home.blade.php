@extends('layouts.master')

@section('title', 'Cổng thông tin đa phương tiện News 24H')

@section('content')
<!-- Google Fonts & Libraries -->
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

{{-- 1. BREAKING NEWS TICKER --}}
<div class="breaking-news-container mb-4 shadow-sm" data-aos="fade-down">
    <div class="d-flex align-items-center h-100">
        <div class="breaking-title px-4 h-100 d-flex align-items-center text-white fw-bold bg-gradient-primary">
            <i class="bi bi-lightning-charge-fill me-2 text-warning"></i>TIN NÓNG
        </div>
        <div class="ticker-content flex-grow-1 overflow-hidden position-relative h-100 d-flex align-items-center">
            <div class="ticker-wrapper">
                @foreach($posts->take(5) as $p)
                    <a href="{{ url('/article/'.$p->slug) }}" class="ticker-item text-decoration-none text-dark small fw-semibold transition-hover hover-text-primary">
                        <span class="text-danger me-2">•</span> <span class="d-inline-block text-truncate" style="max-width: 250px; vertical-align: bottom;">{{ $p->title }}</span>
                    </a>
                @endforeach
            </div>
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
                <div class="card border-0 overflow-hidden shadow-sm main-hero-portal h-100 rounded-4 transition-hover">
                    <a href="{{ url('/article/'.$hero->slug) }}" class="text-decoration-none">
                        <div class="position-relative h-100">
                             <img src="{{ $hero->image ? (str_starts_with($hero->image, 'http') ? $hero->image : asset('storage/' . $hero->image)) : 'https://picsum.photos/id/10/800/600' }}" class="w-100 h-100 object-fit-cover" alt="{{ $hero->title }}" style="min-height: 520px;">
                            <div class="position-absolute bottom-0 start-0 w-100 p-4 p-md-5 hero-gradient-overlay">
                                <span class="badge bg-primary bg-gradient-primary text-white mb-3 px-3 py-2 rounded-pill fw-bold border border-white border-opacity-25 shadow-sm">CHỦ ĐIỂM HÔM NAY</span>
                                <h1 class="display-5 fw-bold text-white mb-3 lh-sm main-title-font line-clamp-2">{{ $hero->title }}</h1>
                                <p class="text-white-50 mb-3 d-none d-md-block line-clamp-2 fs-5">{{ $hero->description }}</p>
                                <div class="d-flex align-items-center text-white-50 small fw-semibold">
                                    <span class="text-info">{{ $hero->category }}</span>
                                    <span class="mx-3 opacity-50">|</span>
                                    <span>{{ $hero->created_at->format('d M, Y') }}</span>
                                    <span class="mx-3 opacity-50">|</span>
                                    <span><i class="bi bi-eye me-1"></i> {{ number_format($hero->views) }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="row g-3 h-100">
                    <div class="col-12" data-aos="fade-left" data-aos-delay="100">
                        <div class="card border-0 overflow-hidden shadow-sm sub-hero-portal rounded-4 transition-hover h-100">
                            <a href="{{ url('/article/'.$subHero1->slug) }}" class="text-decoration-none text-white h-100">
                                <div class="position-relative h-100">
                                     <img src="{{ $subHero1->image ? (str_starts_with($subHero1->image, 'http') ? $subHero1->image : asset('storage/' . $subHero1->image)) : 'https://picsum.photos/id/20/400/300' }}" class="w-100 h-100 object-fit-cover" alt="{{ $subHero1->title }}" style="min-height: 252px;">
                                    <div class="position-absolute bottom-0 start-0 w-100 p-4 hero-gradient-overlay-small">
                                        <small class="badge bg-primary bg-opacity-75 text-white mb-2">{{ $subHero1->category }}</small>
                                        <h5 class="fw-bold mb-0 lh-base line-clamp-2">{{ $subHero1->title }}</h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-12" data-aos="fade-left" data-aos-delay="200">
                        <div class="card border-0 overflow-hidden shadow-sm sub-hero-portal rounded-4 transition-hover h-100">
                            <a href="{{ url('/article/'.$subHero2->slug) }}" class="text-decoration-none text-white h-100">
                                <div class="position-relative h-100">
                                     <img src="{{ $subHero2->image ? (str_starts_with($subHero2->image, 'http') ? $subHero2->image : asset('storage/' . $subHero2->image)) : 'https://picsum.photos/id/30/400/300' }}" class="w-100 h-100 object-fit-cover" alt="{{ $subHero2->title }}" style="min-height: 252px;">
                                    <div class="position-absolute bottom-0 start-0 w-100 p-4 hero-gradient-overlay-small">
                                        <small class="badge bg-primary bg-opacity-75 text-white mb-2">{{ $subHero2->category }}</small>
                                        <h5 class="fw-bold mb-0 lh-base line-clamp-2">{{ $subHero2->title }}</h5>
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
                                 <img src="{{ $bp->image ? (str_starts_with($bp->image, 'http') ? $bp->image : asset('storage/' . $bp->image)) : 'https://picsum.photos/id/100/400/500' }}" class="img-fluid w-100 magazine-img" alt="{{ $bp->title }}" style="height: 400px; object-fit: cover;">
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
                <div class="card border-0 bg-white horizontal-news-card rounded-4 p-3 shadow-sm transition-hover">
                    <div class="row g-0 align-items-center">
                        <div class="col-md-4">
                            <div class="overflow-hidden rounded-3">
                                 <a href="{{ url('/article/'.$post->slug) }}">
                                    <img src="{{ $post->image ? (str_starts_with($post->image, 'http') ? $post->image : asset('storage/' . $post->image)) : 'https://picsum.photos/id/150/400/250' }}" class="img-fluid w-100 transition-scale" alt="{{ $post->title }}" style="height: 200px; object-fit: cover;">
                                </a>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body ps-md-4 py-0 mt-3 mt-md-0">
                                <a href="{{ url('/category/'.$post->category) }}" class="text-decoration-none"><span class="badge bg-primary bg-opacity-10 text-primary mb-2 fw-bold px-3 py-2 rounded-pill">{{ strtoupper($post->category) }}</span></a>
                                <h3 class="h4 fw-bold mt-1 mb-2"><a href="{{ url('/article/'.$post->slug) }}" class="text-decoration-none text-dark card-hover-title line-clamp-2">{{ $post->title }}</a></h3>
                                <p class="text-muted small mb-3 line-clamp-2">{{ $post->description }}</p>
                                <div class="d-flex align-items-center text-muted x-small fw-semibold">
                                    <span class="me-3"><i class="bi bi-clock me-1 text-primary"></i>{{ $post->created_at->diffForHumans() }}</span>
                                    <span><i class="bi bi-chat-dots me-1 text-primary"></i>{{ $post->comments->count() }} bình luận</span>
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
        <div class="card border-0 shadow-sm mb-4 bg-gradient-primary text-white rounded-4 overflow-hidden">
            <div class="card-body p-4 text-center position-relative">
                <i id="weather-icon" class="bi bi-cloud-sun position-absolute top-0 end-0 mt-3 me-3 opacity-25" style="font-size: 4rem;"></i>
                <div class="h5 mb-0 fw-bold position-relative z-1">{{ date('l, d F') }}</div>
                <div class="display-4 fw-bold my-2 position-relative z-1" id="weather-temp">28°C</div>
                <div class="small opacity-75 position-relative z-1">Hà Nội, VN</div>
                <div class="mt-3 x-small bg-white bg-opacity-25 py-2 px-3 rounded-pill position-relative z-1 fw-semibold shadow-sm" id="weather-desc">Dự báo: Đang tải...</div>
            </div>
        </div>

        {{-- Widget: Trending 🔥 --}}
        <div class="card border-0 shadow-sm mb-4 rounded-4">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-fire text-danger me-2"></i> XU HƯỚNG</h5>
            </div>
            <div class="card-body p-4 pt-0">
                @foreach($trendingPosts as $key => $trend)
                <div class="mb-3 pb-3 border-bottom border-light last-no-border d-flex align-items-center">
                    <div class="trending-rank me-3 text-primary opacity-50">{{ $key+1 }}</div>
                    <div>
                        <a href="{{ url('/article/'.$trend->slug) }}" class="text-decoration-none text-dark fw-bold small lh-sm d-block mb-1 trending-title-link line-clamp-2">{{ $trend->title }}</a>
                        <div class="x-small text-muted"><i class="bi bi-eye me-1"></i> {{ number_format($trend->views) }} lượt đọc</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Widget: Thảo luận mới --}}
        <div class="card border-0 shadow-sm mb-4 rounded-4">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-chat-quote-fill text-primary me-2"></i> BÌNH LUẬN</h5>
            </div>
            <div class="card-body p-4 pt-0">
                @php
                    $recentComments = \App\Models\Comment::with('user', 'post')->latest()->take(3)->get();
                @endphp
                @foreach($recentComments as $comm)
                <div class="mb-3 pb-3 border-bottom border-light last-no-border bg-light p-3 rounded-4">
                    <div class="d-flex align-items-center mb-2">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($comm->user->name) }}&background=6366f1&color=fff" class="rounded-circle me-2 shadow-sm" width="24" height="24">
                        <span class="fw-bold x-small text-dark">{{ $comm->user->name }}</span>
                    </div>
                    <a href="{{ url('/article/'.$comm->post->slug) }}" class="text-decoration-none">
                        <p class="text-muted x-small mb-2 font-italic line-clamp-2">"{{ $comm->content }}"</p>
                        <div class="x-small text-primary fw-semibold line-clamp-1"><i class="bi bi-arrow-return-right me-1"></i> {{ $comm->post->title }}</div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Widget: Scan App --}}
        <div class="card border-0 shadow-lg text-center p-4 rounded-4 position-relative overflow-hidden" style="background: var(--text-heading);">
            <div class="position-absolute top-0 start-0 w-100 h-100 bg-gradient-primary opacity-10"></div>
            <h6 class="text-white fw-bold mb-3 position-relative z-1">TẢI APP NEWS 24H</h6>
            <div class="bg-white p-2 d-inline-block rounded-4 mb-3 shadow-sm position-relative z-1">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data=https://news24h.vn" width="120" class="rounded-3">
            </div>
            <p class="text-white-50 x-small px-2 position-relative z-1">Quét mã QR để cập nhật tin tức nhanh nhất trên thiết bị di động.</p>
        </div>
    </div>
</div>

<style>
    .main-title-font { font-family: 'Playfair Display', serif; }
    .serif-font { font-family: 'Playfair Display', serif; }
    .x-small { font-size: 0.75rem; }
    .ls-2 { letter-spacing: 2px; }

    /* Breaking News Ticker Animation */
    .breaking-news-container { background: white; border-radius: 50px; overflow: hidden; height: 45px; }
    .breaking-title { z-index: 2; position: relative; }
    .ticker-wrapper {
        display: flex;
        width: max-content;
        animation: ticker-slide 20s linear infinite;
    }
    .ticker-wrapper:hover {
        animation-play-state: paused;
    }
    .ticker-item {
        padding: 0 30px;
        white-space: nowrap;
    }
    @keyframes ticker-slide {
        0% { transform: translateX(100%); }
        100% { transform: translateX(-100%); }
    }
    
    /* Hero Portal */
    .hero-gradient-overlay { background: linear-gradient(to top, rgba(15, 23, 42, 0.95) 0%, rgba(15, 23, 42, 0.4) 50%, transparent 100%); transition: 0.5s; }
    .hero-gradient-overlay-small { background: linear-gradient(to top, rgba(15, 23, 42, 0.9) 0%, transparent 100%); }
    .main-hero-portal img { transition: 1s cubic-bezier(0.4, 0, 0.2, 1); }
    .main-hero-portal:hover img { transform: scale(1.05); }

    /* Magazine Card */
    .magazine-img { transition: 0.8s cubic-bezier(0.4, 0, 0.2, 1); }
    .magazine-card:hover .magazine-img { transform: scale(1.05); }
    .magazine-card h4 { transition: 0.3s; line-height: 1.3; }
    .magazine-card:hover h4 { color: var(--primary-color); }

    /* Horizontal Card */
    .horizontal-news-card .transition-scale { transition: 0.6s cubic-bezier(0.4, 0, 0.2, 1); }
    .horizontal-news-card:hover .transition-scale { transform: scale(1.1); }
    .card-hover-title { transition: 0.3s; }
    .horizontal-news-card:hover .card-hover-title { color: var(--primary-color) !important; }

    /* Sidebar Widgets */
    .trending-rank { font-size: 2rem; font-family: 'Outfit', sans-serif; font-weight: 900; line-height: 1; min-width: 35px; }
    .trending-title-link:hover { color: var(--primary-color) !important; }
    .last-no-border:last-child { border: 0 !important; margin-bottom: 0 !important; padding-bottom: 0 !important; }

    .section-title-premium { font-family: 'Playfair Display', serif; font-size: 2.2rem; font-weight: 700; color: var(--text-heading); }
    .section-title-portal { position: relative; padding-bottom: 15px; color: var(--text-heading); }
    .section-title-portal::after { content: ""; position: absolute; bottom: 0; left: 0; width: 60px; height: 4px; background: var(--primary-color); border-radius: 4px; }
</style>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ duration: 1000, once: true });

    // Fetch Weather Data from Open-Meteo (Free API, No Key required)
    (function() {
        const lat = 21.0285; // Hà Nội
        const lon = 105.8542;
        
        fetch(`https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&current=temperature_2m,weather_code`)
            .then(response => response.json())
            .then(data => {
                if (data && data.current) {
                    const temp = Math.round(data.current.temperature_2m);
                    const code = data.current.weather_code;
                    
                    // Map Weather Code (WMO standards)
                    let desc = "Không rõ";
                    let iconClass = "bi-cloud-sun";
                    
                    const weatherMap = {
                        0: { desc: "Trời quang, nắng", icon: "bi-sun-fill" },
                        1: { desc: "Ít mây, nắng nhẹ", icon: "bi-cloud-sun-fill" },
                        2: { desc: "Mây rải rác", icon: "bi-cloud-sun" },
                        3: { desc: "Nhiều mây, u ám", icon: "bi-cloudy-fill" },
                        45: { desc: "Sương mù", icon: "bi-cloud-fog-fill" },
                        48: { desc: "Sương muối", icon: "bi-cloud-fog2" },
                        51: { desc: "Mưa phùn nhẹ", icon: "bi-cloud-drizzle" },
                        53: { desc: "Mưa phùn vừa", icon: "bi-cloud-drizzle-fill" },
                        55: { desc: "Mưa phùn lớn", icon: "bi-cloud-drizzle-fill" },
                        61: { desc: "Mưa rào nhẹ", icon: "bi-cloud-rain" },
                        63: { desc: "Mưa vừa", icon: "bi-cloud-rain-fill" },
                        65: { desc: "Mưa to", icon: "bi-cloud-rain-heavy-fill" },
                        80: { desc: "Mưa rào nhẹ", icon: "bi-cloud-rain" },
                        81: { desc: "Mưa rào vừa", icon: "bi-cloud-rain-fill" },
                        82: { desc: "Mưa rào rất to", icon: "bi-cloud-rain-heavy-fill" },
                        95: { desc: "Mưa giông", icon: "bi-cloud-lightning-rain-fill" },
                        96: { desc: "Mưa giông, mưa đá", icon: "bi-cloud-lightning-rain" },
                        99: { desc: "Mưa giông lớn", icon: "bi-cloud-lightning-rain-fill" }
                    };
                    
                    if (weatherMap[code]) {
                        desc = weatherMap[code].desc;
                        iconClass = weatherMap[code].icon;
                    }
                    
                    document.getElementById('weather-temp').textContent = `${temp}°C`;
                    document.getElementById('weather-desc').textContent = `Dự báo: ${desc}`;
                    
                    const iconElement = document.getElementById('weather-icon');
                    if (iconElement) {
                        iconElement.className = `bi ${iconClass} position-absolute top-0 end-0 mt-3 me-3 opacity-25`;
                    }
                }
            })
            .catch(err => {
                console.error("Lỗi lấy dữ liệu thời tiết:", err);
                document.getElementById('weather-desc').textContent = "Dự báo: Có mây, nắng nhẹ";
            });
    })();
</script>
@endsection