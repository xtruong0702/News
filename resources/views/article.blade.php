@extends('layouts.master')

@section('title', $post->title)

@section('content')
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Lora:ital,wght@0,400;0,600;1,400&family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">

{{-- Reading Progress Bar --}}
<div id="reading-progress" class="position-fixed top-0 start-0 vh-100" style="width: 4px; background: #6366f1; z-index: 9999; transform: scaleY(0); transform-origin: top;"></div>

<div class="row justify-content-center g-5">
    {{-- Cột nội dung chính --}}
    <article class="col-lg-8 main-article" style="background: white; padding: 40px; border-radius: 24px; shadow: 0 10px 30px rgba(0,0,0,0.05);">
        
        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb small bg-light p-2 rounded-pill px-4">
                <li class="breadcrumb-item"><a href="/" class="text-decoration-none text-muted">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/category/'.$post->category) }}" class="text-decoration-none text-primary fw-bold">{{ $post->category }}</a></li>
                <li class="breadcrumb-item active text-truncate" style="max-width: 200px;" aria-current="page">{{ $post->title }}</li>
            </ol>
        </nav>

        <header class="mb-5">
            <h1 class="display-4 fw-black mb-4 article-title" style="font-family: 'Playfair Display', serif; line-height: 1.1; color: #0f172a;">
                {{ $post->title }}
            </h1>

            <div class="d-flex align-items-center py-4 border-top border-bottom">
                <div class="position-relative">
                    <img src="https://ui-avatars.com/api/?name=Admin&background=6366f1&color=fff" class="rounded-circle me-3 border border-2 border-white shadow-sm" width="55" height="55" alt="Author">
                    <span class="position-absolute bottom-0 end-0 bg-success border border-white rounded-circle p-1" style="margin-right: 15px;"></span>
                </div>
                <div>
                    <p class="mb-0 fw-bold text-dark">Admin</p>
                    <small class="text-muted">
                        <i class="bi bi-calendar3 me-1"></i> {{ $post->created_at->format('d M, Y') }} 
                        <span class="mx-2">•</span> 
                        <i class="bi bi-eye me-1"></i> {{ number_format($post->views) }} lượt xem
                    </small>
                </div>

                <div class="ms-auto d-none d-md-flex gap-2">
                    <button class="btn btn-light btn-sm rounded-circle shadow-sm" title="Lưu bài viết"><i class="bi bi-bookmark"></i></button>
                    <button class="btn btn-light btn-sm rounded-circle shadow-sm" title="Chia sẻ"><i class="bi bi-share"></i></button>
                </div>
            </div>
        </header>

        <div class="article-body" style="font-family: 'Lora', serif; font-size: 1.2rem; line-height: 1.9; color: #334155;">
            {{-- Sapo / Description --}}
            <div class="lead fw-bold mb-5 ps-4 border-start border-4 border-primary italic-text" style="color: #1e293b; font-size: 1.3rem;">
                {{ $post->description }}
            </div>

            {{-- Main Image --}}
            @if($post->image)
            <figure class="mb-5 text-center">
                <img src="{{ $post->image }}" class="img-fluid rounded-4 shadow-lg mb-2" alt="{{ $post->title }}" style="width: 100%; max-height: 600px; object-fit: cover;">
                <figcaption class="text-muted small italic-text mt-2"><i class="bi bi-camera me-1"></i> Hình ảnh minh họa cho bài viết: {{ $post->title }}</figcaption>
            </figure>
            @endif

            {{-- Real Content --}}
            <div class="content-text first-letter-big">
                {!! $post->content !!}
            </div>
        </div>

        {{-- Tags Section --}}
        <div class="mt-5 pt-4 border-top">
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <span class="fw-bold me-2 text-dark"><i class="bi bi-tags me-1"></i> Tags:</span>
                <a href="#" class="tag-item">#{{ $post->category }}</a>
                <a href="#" class="tag-item">#News2026</a>
                <a href="#" class="tag-item">#HotTopic</a>
            </div>
        </div>

        {{-- Author Bio Card --}}
        <div class="author-card mt-5 p-4 rounded-4 bg-light d-flex align-items-center shadow-sm">
            <img src="https://ui-avatars.com/api/?name=Admin&background=0f172a&color=fff" class="rounded-circle me-4" width="80" height="80">
            <div>
                <h5 class="fw-bold mb-1">Viết bởi: Admin</h5>
                <p class="text-muted small mb-2">Biên tập viên cao cấp tại News 24H. Chuyên trách mảng Công nghệ và Đời sống số.</p>
                <div class="d-flex gap-3">
                    <a href="#" class="text-primary"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-info"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="text-danger"><i class="bi bi-envelope"></i></a>
                </div>
            </div>
        </div>

        {{-- Tin liên quan --}}
        <section class="mt-5 py-5 border-top">
            <h3 class="fw-bold mb-4" style="font-family: 'Playfair Display', serif;">Tin liên quan</h3>
            <div class="row g-4">
                @php
                    $relatedPosts = \App\Models\Post::where('category', $post->category)->where('id', '!=', $post->id)->take(3)->get();
                @endphp
                @foreach($relatedPosts as $rp)
                <div class="col-md-4">
                    <div class="card border-0 h-100 related-post-card">
                        <a href="{{ url('/article/'.$rp->slug) }}" class="text-decoration-none text-dark">
                            <img src="{{ $rp->image ?? 'https://picsum.photos/id/50/400/250' }}" class="card-img-top rounded-3 mb-2" alt="{{ $rp->title }}" style="height: 150px; object-fit: cover;">
                            <h6 class="fw-bold lh-base">{{ Str::limit($rp->title, 60) }}</h6>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </section>

        {{-- Hệ thống Bình luận --}}
        <section class="mt-5 pt-5 border-top" id="comments">
            <div class="d-flex align-items-center justify-content-between mb-5">
                <h3 class="fw-bold m-0" style="font-family: 'Playfair Display', serif;">Bình luận ({{ $post->comments->count() }})</h3>
                <div class="badge bg-primary rounded-pill">{{ $post->comments->count() }} thảo luận</div>
            </div>

            @auth
                <div class="card border-0 shadow-sm mb-5 rounded-4 overflow-hidden">
                    <div class="card-body p-4 bg-light">
                        <form action="{{ route('comments.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <div class="d-flex gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=6366f1&color=fff" class="rounded-circle shadow-sm" width="40" height="40">
                                <div class="flex-grow-1">
                                    <textarea name="content" class="form-control border-0 shadow-none bg-white p-3 rounded-4" rows="3" placeholder="Chia sẻ ý kiến của bạn về bài viết này..." required></textarea>
                                    <div class="text-end mt-3">
                                        <button type="submit" class="btn btn-primary px-5 rounded-pill fw-bold">Gửi bình luận <i class="bi bi-send ms-2"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <div class="text-center py-5 bg-light rounded-4 mb-5 border-dashed">
                    <i class="bi bi-chat-left-dots display-4 text-muted mb-3 d-block"></i>
                    <p class="text-muted">Bạn cần đăng nhập để tham gia thảo luận.</p>
                    <a href="/login" class="btn btn-primary px-4 rounded-pill">Đăng nhập ngay</a>
                </div>
            @endauth

            <div class="comment-list">
                @foreach($post->comments as $comment)
                <div class="d-flex mb-4 p-4 rounded-4 comment-bubble">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name) }}&background=random" class="rounded-circle me-3 shadow-sm" width="50" height="50" alt="Avatar">
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="mb-0 fw-bold text-dark">{{ $comment->user->name }}</h6>
                            <small class="text-muted x-small">{{ $comment->created_at->diffForHumans() }}</small>
                        </div>
                        <div class="comment-text-box">
                            {{ $comment->content }}
                        </div>
                    </div>
                </div>
                @endforeach

                @if($post->comments->count() == 0)
                    <div class="text-center py-5 opacity-50">
                        <p>Chưa có bình luận nào cho bài viết này.</p>
                    </div>
                @endif
            </div>
        </section>
    </article>

    {{-- Sidebar (tùy chọn cho trang chi tiết) --}}
    <div class="col-lg-4 d-none d-lg-block">
        <div class="sticky-top" style="top: 100px;">
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                <h5 class="fw-bold mb-3 border-bottom pb-2">Đọc nhiều nhất</h5>
                @php $topPosts = \App\Models\Post::orderBy('views', 'desc')->take(4)->get(); @endphp
                @foreach($topPosts as $tp)
                <div class="mb-3">
                    <a href="{{ url('/article/'.$tp->slug) }}" class="text-decoration-none text-dark d-flex gap-3">
                        <img src="{{ $tp->image }}" class="rounded-2" width="60" height="60" style="object-fit: cover;">
                        <h6 class="small fw-bold mb-0 lh-base hover-primary">{{ Str::limit($tp->title, 50) }}</h6>
                    </a>
                </div>
                @endforeach
            </div>

            <div class="card border-0 shadow-lg text-white p-4 rounded-4" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);">
                <h5 class="fw-bold mb-3">Newsletter</h5>
                <p class="small opacity-75">Đừng bỏ lỡ các tin tức quan trọng hàng ngày.</p>
                <div class="input-group">
                    <input type="text" class="form-control border-0 bg-white bg-opacity-10 text-white" placeholder="Email...">
                    <button class="btn btn-primary"><i class="bi bi-arrow-right"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body { font-family: 'Outfit', sans-serif; background-color: #f1f5f9; }
    .x-small { font-size: 0.75rem; }
    .italic-text { font-style: italic; }
    .fw-black { font-weight: 900; }
    
    .article-title { color: #1e293b; letter-spacing: -1px; }
    .tag-item { 
        background: #e2e8f0; color: #475569; padding: 5px 15px; 
        border-radius: 50px; text-decoration: none; font-size: 0.8rem; font-weight: 600;
        transition: all 0.3s;
    }
    .tag-item:hover { background: #6366f1; color: white; transform: translateY(-2px); }

    .first-letter-big:first-letter {
        float: left; font-family: 'Playfair Display', serif;
        font-size: 5rem; line-height: 1; font-weight: 900;
        padding-right: 15px; color: #6366f1;
    }

    .comment-bubble { background: #fff; transition: transform 0.3s; border: 1px solid #f1f5f9; }
    .comment-bubble:hover { transform: translateX(10px); background: #f8fafc; }
    .comment-text-box { font-family: 'Lora', serif; font-size: 1.1rem; line-height: 1.6; color: #475569; }

    .border-dashed { border: 2px dashed #e2e8f0; }
    .related-post-card img { transition: 0.5s; }
    .related-post-card:hover img { transform: scale(1.05); }
    .hover-primary:hover { color: #6366f1 !important; }
</style>

<script>
    // Xử lý thanh Reading Progress
    window.onscroll = function() {
        let winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        let height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        let scrolled = (winScroll / height);
        document.getElementById("reading-progress").style.transform = "scaleY(" + scrolled + ")";
    };
</script>
@endsection