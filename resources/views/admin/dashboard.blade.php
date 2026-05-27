@extends('layouts.admin')

@section('title', 'Bảng điều khiển')

@section('content')
<div class="container-fluid">
    <h2 class="fw-bold mb-4">Tổng quan hệ thống</h2>
    
    <div class="row">
        @php
            $user = Auth::user();
            if ($user->role === 'admin') {
                $totalPosts = \App\Models\Post::count();
                $publishedPosts = \App\Models\Post::where('status', 'published')->count();
                $pendingPosts = \App\Models\Post::where('status', 'pending')->count();
                $totalViews = \App\Models\Post::sum('views');
            } else {
                // Thống kê dành riêng cho Writer
                $totalPosts = \App\Models\Post::where('user_id', $user->id)->count();
                $publishedPosts = \App\Models\Post::where('user_id', $user->id)->where('status', 'published')->count();
                $pendingPosts = \App\Models\Post::where('user_id', $user->id)->where('status', 'pending')->count();
                $totalViews = \App\Models\Post::where('user_id', $user->id)->sum('views');
            }
        @endphp

        <div class="col-md-3 mb-4">
            <div class="card card-stats bg-primary text-white shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">{{ $user->role === 'admin' ? 'Tổng bài viết' : 'Bài của tôi' }}</h6>
                            <h2 class="fw-bold mb-0">{{ $totalPosts }}</h2>
                        </div>
                        <i class="bi bi-file-earmark-text fs-1"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card card-stats bg-success text-white shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Đã xuất bản</h6>
                            <h2 class="fw-bold mb-0">{{ $publishedPosts }}</h2>
                        </div>
                        <i class="bi bi-check-circle fs-1"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card card-stats bg-danger text-white shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Chờ duyệt</h6>
                            <h2 class="fw-bold mb-0">{{ $pendingPosts }}</h2>
                        </div>
                        <i class="bi bi-clock-history fs-1"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card card-stats bg-warning text-dark shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Lượt xem</h6>
                            <h2 class="fw-bold mb-0">{{ number_format($totalViews) }}</h2>
                        </div>
                        <i class="bi bi-eye fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            @if($user->role === 'admin')
                <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 15px;">
                    <div class="card-body text-center py-5">
                        <h4 class="fw-bold">Chào mừng {{ Auth::user()->name }} quay trở lại!</h4>
                        <p class="text-muted">Bạn đang đăng nhập với vai trò: <span class="badge bg-primary">{{ Auth::user()->role }}</span></p>
                        <a href="/admin/posts/create" class="btn btn-primary btn-lg px-5 rounded-pill shadow">Viết bài mới ngay</a>
                    </div>
                </div>
            @else
                <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 15px; background: linear-gradient(135deg, #4f46e5 0%, #818cf8 100%); color: white;">
                    <div class="card-body p-5">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h2 class="fw-bold mb-3">Chào buổi sáng, {{ Auth::user()->name }}! ✨</h2>
                                <p class="lead mb-4" style="opacity: 0.9;">Hôm nay là một ngày tuyệt vời để chia sẻ những câu chuyện mới. Hãy bắt đầu sáng tạo nội dung ngay thôi!</p>
                                <a href="/admin/posts/create" class="btn btn-light btn-lg px-5 rounded-pill shadow-sm fw-bold" style="color: #4f46e5;">
                                    <i class="bi bi-plus-circle me-2"></i>Tạo bài viết mới
                                </a>
                            </div>
                            <div class="col-md-4 text-center d-none d-md-block">
                                <i class="bi bi-pencil-square" style="font-size: 8rem; opacity: 0.2;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection