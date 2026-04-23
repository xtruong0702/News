@extends('layouts.admin')

@section('title', 'Bảng điều khiển')

@section('content')
<div class="container-fluid">
    <h2 class="fw-bold mb-4">Tổng quan hệ thống</h2>
    
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card card-stats bg-primary text-white shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Tổng bài viết</h6>
                            <h2 class="fw-bold mb-0">{{ \App\Models\Post::count() }}</h2>
                        </div>
                        <i class="bi bi-file-earmark-text fs-1"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card card-stats bg-success text-white shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Chuyên mục</h6>
                            <h2 class="fw-bold mb-0">3</h2> </div>
                        <i class="bi bi-grid fs-1"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card card-stats bg-warning text-dark shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1">Tổng lượt xem</h6>
                            <h2 class="fw-bold mb-0">{{ \App\Models\Post::sum('views') }}</h2>
                        </div>
                        <i class="bi bi-eye fs-1"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <h4>Chào mừng Admin quay trở lại!</h4>
                    
                    <a href="/admin/posts/create" class="btn btn-primary">Viết bài mới ngay</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection