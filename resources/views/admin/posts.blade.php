@extends('layouts.admin')

@section('title', 'Danh sách bài viết')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Quản lý bài viết</h2>
        <a href="/admin/posts/create" class="btn btn-primary">
            <i class="bi bi-plus-lg me-2"></i>Thêm bài viết mới
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <ul class="nav nav-pills mb-4 gap-2">
        <li class="nav-item">
            <a class="nav-link {{ !request('status') ? 'active' : 'bg-white border text-dark' }} rounded-pill px-4 shadow-sm" href="/admin/posts">
                Tất cả bài viết
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('status') === 'pending' ? 'active' : 'bg-white border text-dark' }} rounded-pill px-4 shadow-sm" href="/admin/posts?status=pending">
                Đang chờ duyệt 
                @php 
                    $pendingQuery = \App\Models\Post::where('status', 'pending');
                    if (Auth::user()->role !== 'admin') {
                        $pendingQuery->where('user_id', Auth::user()->id);
                    }
                    $pendingCount = $pendingQuery->count(); 
                @endphp
                @if($pendingCount > 0)
                <span class="badge bg-danger ms-2">{{ $pendingCount }}</span>
                @endif
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('status') === 'published' ? 'active' : 'bg-white border text-dark' }} rounded-pill px-4 shadow-sm" href="/admin/posts?status=published">
                Đã xuất bản
            </a>
        </li>
    </ul>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Hình ảnh</th>
                        <th>Nội dung</th>
                        <th>Tác giả</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                    <tr>
                        <td>#{{ $post->id }}</td>
                        <td>
                            @if($post->image)
                                <img src="{{ str_starts_with($post->image, 'http') ? $post->image : asset('storage/' . $post->image) }}" class="rounded shadow-sm" width="80" height="50" style="object-fit: cover;">
                            @else
                                <div class="bg-light border rounded text-center d-flex align-items-center justify-content-center" style="width: 80px; height: 50px; font-size: 10px;">No Image</div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold text-dark line-clamp-1">{{ $post->title }}</div>
                            <small class="text-muted"><i class="bi bi-tag me-1"></i>{{ $post->category }} | <i class="bi bi-eye me-1"></i>{{ number_format($post->views) }}</small>
                        </td>
                        <td>
                            <div class="small fw-bold text-primary">{{ $post->user ? $post->user->name : 'Hệ thống' }}</div>
                        </td>
                        <td>
                            @if($post->status === 'published')
                                <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 rounded-pill border border-success border-opacity-25">
                                    <i class="bi bi-check-circle-fill me-1"></i> Đã đăng
                                </span>
                            @elseif($post->status === 'pending')
                                <span class="badge bg-warning bg-opacity-10 text-warning px-3 py-2 rounded-pill border border-warning border-opacity-25">
                                    <i class="bi bi-clock-fill me-1"></i> Chờ duyệt
                                </span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill border border-danger border-opacity-25">
                                    <i class="bi bi-x-circle-fill me-1"></i> Từ chối
                                </span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="d-flex justify-content-end gap-1">
                                {{-- Nút Duyệt (Chỉ cho Admin) --}}
                                @if(Auth::user()->role === 'admin' && $post->status === 'pending')
                                <form action="{{ route('posts.approve', $post->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success rounded-3" title="Duyệt bài">
                                        <i class="bi bi-check-lg"></i> Duyệt
                                    </button>
                                </form>
                                @endif

                                {{-- Nút Sửa (Writer không được sửa bài đã đăng) --}}
                                @if(Auth::user()->role === 'admin' || (Auth::user()->role === 'writer' && $post->status !== 'published'))
                                <a href="{{ url('/admin/posts/'.$post->id.'/edit') }}" class="btn btn-sm btn-outline-primary rounded-3" title="Sửa bài">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @endif

                                <form action="{{ url('/admin/posts/'.$post->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-3" onclick="return confirm('Bạn có chắc chắn muốn xóa bài viết này?')" title="Xóa bài">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            <div class="d-flex justify-content-end mt-4">
                <nav>
                    <ul class="pagination pagination-sm">
                        <li class="page-item disabled"><a class="page-link" href="#">Lùi</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">Tiến</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
@endsection