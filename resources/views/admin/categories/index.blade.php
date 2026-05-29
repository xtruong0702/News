@extends('layouts.admin')

@section('title', 'Quản lý Chuyên mục')

@section('content')
<div class="container-fluid">
    {{-- Hiển thị thông báo thành công hoặc lỗi --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif



    {{-- Danh sách bài viết theo chuyên mục --}}
    <div class="row g-4">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white py-3 border-0 d-md-flex justify-content-between align-items-center">
                    <h5 class="mb-3 mb-md-0 fw-bold text-dark"><i class="bi bi-file-earmark-post me-2 text-primary"></i>Danh sách Bài viết thuộc Chuyên mục</h5>
                    {{-- Bộ lọc Chuyên mục dạng Tab --}}
                    <div class="d-flex flex-wrap gap-2" id="category-filter-pills">
                        <button type="button" class="btn btn-sm btn-primary rounded-pill px-3 py-1 fw-bold filter-pill active" data-filter="all">
                            Tất cả ({{ $posts->count() }})
                        </button>
                        @foreach($categories as $cat)
                            <button type="button" class="btn btn-sm btn-light rounded-pill px-3 py-1 fw-bold filter-pill" data-filter="{{ $cat->name }}">
                                {{ $cat->name }} ({{ $cat->posts_count }})
                            </button>
                        @endforeach
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive" style="max-height: 550px; overflow-y: auto;">
                        <table class="table table-hover align-middle mb-0" id="posts-filter-table">
                            <thead class="table-light sticky-top">
                                <tr>
                                    <th class="ps-4" style="width: 80px;">ID</th>
                                    <th style="width: 100px;">Ảnh</th>
                                    <th>Tiêu đề bài viết</th>
                                    <th>Chuyên mục</th>
                                    <th>Tác giả</th>
                                    <th>Trạng thái</th>
                                    <th>Lượt xem</th>
                                    <th>Ngày tạo</th>
                                    <th class="text-center pe-4" style="width: 150px;">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($posts as $post)
                                    <tr class="post-row" data-category="{{ $post->category }}">
                                        <td class="ps-4 text-muted fw-bold">#{{ $post->id }}</td>
                                        <td>
                                            <img src="{{ $post->image ? (str_starts_with($post->image, 'http') ? $post->image : asset('storage/' . $post->image)) : 'https://picsum.photos/seed/'.$post->id.'/100/60' }}" 
                                                 class="rounded shadow-sm" width="80" height="50" style="object-fit: cover;">
                                        </td>
                                        <td>
                                            <a href="{{ url('/article/'.$post->slug) }}" target="_blank" class="fw-bold text-dark text-decoration-none hover-text-primary line-clamp-1">
                                                {{ $post->title }}
                                            </a>
                                            <small class="text-muted d-block line-clamp-1">{{ Str::limit($post->description, 80) }}</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-1 fw-bold">
                                                {{ $post->category }}
                                            </span>
                                        </td>
                                        <td>
                                            <small class="fw-semibold text-secondary">{{ $post->user ? $post->user->name : 'N/A' }}</small>
                                        </td>
                                        <td>
                                            @if($post->status === 'published')
                                                <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1 fw-bold">Đã xuất bản</span>
                                            @else
                                                <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-1 fw-bold">Chờ duyệt</span>
                                            @endif
                                        </td>
                                        <td>
                                            <small class="fw-bold text-secondary"><i class="bi bi-eye me-1"></i>{{ number_format($post->views) }}</small>
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ $post->created_at ? $post->created_at->format('d/m/Y H:i') : '---' }}</small>
                                        </td>
                                        <td class="text-center pe-4">
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="/admin/posts/{{ $post->id }}/edit" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                                                    <i class="bi bi-pencil me-1"></i>Sửa
                                                </a>
                                                <form action="/admin/posts/{{ $post->id }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bài viết này?')" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                                        <i class="bi bi-trash me-1"></i>Xóa
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-5 text-muted">
                                            <i class="bi bi-file-earmark-post fs-1 d-block mb-3 opacity-50"></i>
                                            Chưa có bài viết nào được tạo.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Script lọc danh sách bài viết theo Chuyên mục siêu mượt (Instant JS filter) --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterPills = document.querySelectorAll('.filter-pill');
        const postRows = document.querySelectorAll('.post-row');

        filterPills.forEach(pill => {
            pill.addEventListener('click', function() {
                // Xóa active class ở các pills khác
                filterPills.forEach(p => {
                    p.classList.remove('btn-primary', 'active');
                    p.classList.add('btn-light');
                });
                // Thêm active class cho pill hiện tại
                this.classList.remove('btn-light');
                this.classList.add('btn-primary', 'active');

                const filterValue = this.getAttribute('data-filter');

                // Ẩn/Hiện dòng tương ứng trong bảng
                postRows.forEach(row => {
                    const rowCategory = row.getAttribute('data-category');
                    if (filterValue === 'all' || rowCategory === filterValue) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    });
</script>
@endsection
