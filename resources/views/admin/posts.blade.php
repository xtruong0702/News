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

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Hình ảnh</th>
                        <th>Tiêu đề</th>
                        <th>Chuyên mục</th>
                        <th>Lượt xem</th>
                        <th>Ngày đăng</th>

                        <th>Trạng thái</th>
                        <th class="text-end">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                    <tr>
                        <td>#{{ $post->id }}</td>
                        <td>
                            @if($post->image)
                                <img src="{{ $post->image }}" class="rounded" width="100" height="60" style="object-fit: cover;" alt="news">
                            @else
                                <div class="bg-secondary text-white rounded text-center d-flex align-items-center justify-content-center" style="width: 100px; height: 60px; font-size: 10px;">No Image</div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $post->title }}</div>
                            <small class="text-muted">Slug: {{ $post->slug }}</small>
                        </td>
                        <td><span class="badge bg-info text-dark">{{ $post->category }}</span></td>
                        <td class="fw-bold"><i class="bi bi-eye"></i> {{ number_format($post->views) }}</td>
                        <td>{{ $post->created_at->format('d/m/Y') }}</td>

                        <td><span class="badge bg-success">Đã xuất bản</span></td>
                        <td class="text-end">
                            <a href="{{ url('/admin/posts/'.$post->id.'/edit') }}" class="btn btn-sm btn-outline-primary me-1">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <form action="{{ url('/admin/posts/'.$post->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa bài viết này?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
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