@extends('layouts.master')

@section('title', 'Chuyên mục: ' . $name)

@section('content')
<div class="container">
    <h1 class="mb-4 border-bottom pb-3">Chuyên mục: <span class="text-primary">{{ $name }}</span></h1>
    
    <div class="row">
        @forelse($posts as $post)
        <div class="col-md-4 mb-4">
            <div class="card card-news h-100 shadow-sm border-0">
                <img src="{{ str_starts_with($post->image, 'http') ? $post->image : asset('storage/' . $post->image) }}" class="card-img-top p-2 rounded-4" alt="{{ $post->title }}">
                <div class="card-body">
                    <h5 class="card-title fw-bold">
                        <a href="{{ url('/article/' . $post->slug) }}" class="text-decoration-none text-dark">
                            {{ $post->title }}
                        </a>
                    </h5>
                    <p class="text-muted small">{{ Str::limit($post->description, 100) }}</p>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <p class="text-muted">Chưa có bài viết nào trong chuyên mục này.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection