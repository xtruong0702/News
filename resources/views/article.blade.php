@extends('layouts.master')

@section('title', 'Chi tiết bài viết')

@section('content')
<div class="row justify-content-center">
    <article class="col-lg-8">
        
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item"><a href="/" class="text-decoration-none">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="#" class="text-decoration-none">Công nghệ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tin tức chi tiết</li>
            </ol>
        </nav>

        <header class="mb-4">
            <h1 class="display-5 fw-bold mb-3" style="font-family: 'Inter', sans-serif; line-height: 1.2;">
                {{ $post->title }}
            </h1>

            
            <div class="d-flex align-items-center py-3 border-top border-bottom">
                <img src="https://ui-avatars.com/api/?name=Admin&background=1E3A8A&color=fff" class="rounded-circle me-3" width="45" alt="Author">
                <div>
                    <p class="mb-0 fw-bold">Tác giả: Admin</p>
                    <small class="text-muted">
                        {{ $post->created_at->format('d/m/Y') }} • 
                        {{ number_format($post->views) }} lượt xem
                    </small>
                </div>

                <div class="ms-auto">
                    <button class="btn btn-outline-primary btn-sm me-1">Chia sẻ</button>
                    <button class="btn btn-outline-secondary btn-sm">Lưu tin</button>
                </div>
            </div>
        </header>

        <div class="article-content" style="font-size: 18px; line-height: 1.8;">
            <p class="fw-bold lead mb-4">
                {{ $post->description }}
            </p>

            @if($post->image)
            <img src="{{ $post->image }}" class="img-fluid rounded-3 mb-4 shadow-sm" alt="{{ $post->title }}" style="width: 100%; max-height: 500px; object-fit: cover;">
            @endif

            <div class="content-body">
                {!! $post->content !!}
            </div>

                Kết luận, tương lai của lập trình web không nằm ở việc ai code nhanh hơn, mà nằm ở việc ai có khả năng giải quyết vấn đề tốt hơn thông qua các công cụ hỗ trợ thông minh.
            </p>
        </div>

        <div class="mt-5 pt-3 border-top">
            <span class="fw-bold me-2">Tags:</span>
            <a href="#" class="badge bg-light text-dark border text-decoration-none p-2 mb-1">Laravel</a>
            <a href="#" class="badge bg-light text-dark border text-decoration-none p-2 mb-1">Công nghệ 2026</a>
            <a href="#" class="badge bg-light text-dark border text-decoration-none p-2 mb-1">Lập trình</a>
        </div>

        <section class="mt-5 py-4 border-top">
            <h4 class="fw-bold mb-4">Bài viết cùng chuyên mục</h4>
            <div class="row">
                @for ($i = 0; $i < 3; $i++)
                <div class="col-md-4 mb-3">
                    <div class="card card-news h-100 border-0 shadow-sm">
                        <img src="https://picsum.photos/id/{{$i+20}}/300/180" class="card-img-top rounded-2" alt="related">
                        <div class="card-body p-2">
                            <h6 class="card-title fw-bold">Tin liên quan số {{$i+1}}</h6>
                        </div>
                    </div>
                </div>
                @endfor
            </div>
        </section>
    </article>
</div>
@endsection