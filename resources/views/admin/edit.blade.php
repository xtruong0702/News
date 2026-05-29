@extends('layouts.admin')

@section('title', 'Chỉnh sửa bài viết')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Chỉnh sửa bài viết: <span class="text-primary">{{ $post->title }}</span></h5>
                </div>
                <div class="card-body">
                    <form action="{{ url('/admin/posts/'.$post->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf 
                        @method('PUT') 
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tiêu đề bài viết</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $post->title) }}" required>
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Chuyên mục</label>
                                <select name="category" class="form-select">
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->name }}" {{ old('category', $post->category) == $cat->name ? 'selected' : '' }}>{{ $cat->name }}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Thay đổi hình ảnh</label>
                                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                                @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                @if($post->image)
                                    <div class="mt-2">
                                        <small class="text-muted d-block mb-1">Ảnh hiện tại:</small>
                                        <img src="{{ str_starts_with($post->image, 'http') ? $post->image : asset('storage/' . $post->image) }}" class="rounded shadow-sm" width="100" alt="Current Image">
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Mô tả ngắn</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="2">{{ old('description', $post->description) }}</textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label fw-bold mb-0">Nội dung chi tiết</label>
                                <button type="button" id="ai-rewrite-btn" class="btn btn-sm btn-outline-primary rounded-pill">
                                    <i class="bi bi-magic me-1"></i> AI Sửa bài (Sắp xếp & Làm mượt)
                                </button>
                            </div>
                            <div id="ai-loading" class="small text-primary mb-2 d-none">
                                <span class="spinner-border spinner-border-sm me-2"></span> AI đang đọc và sắp xếp lại bài viết...
                            </div>
                            <textarea id="tinymce-editor" name="content" class="form-control @error('content') is-invalid @enderror" rows="15">{{ old('content', $post->content) }}</textarea>
                            @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="text-end">
                            <a href="/admin/posts" class="btn btn-light me-2">Hủy</a>
                            <button type="submit" class="btn btn-success px-4">Cập nhật bài viết</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    let editorInstance;
    ClassicEditor
        .create(document.querySelector('#tinymce-editor'), {
            toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'insertTable', 'undo', 'redo' ]
        })
        .then(editor => {
            editorInstance = editor;
        })
        .catch(error => {
            console.error(error);
        });

    // AI Rewrite Logic
    document.getElementById('ai-rewrite-btn').addEventListener('click', function() {
        const content = editorInstance.getData();
        if (!content || content.trim() === '') {
            alert('Bài viết chưa có nội dung để sửa!');
            return;
        }

        const btn = this;
        const loading = document.getElementById('ai-loading');
        
        btn.disabled = true;
        loading.classList.remove('d-none');

        fetch('{{ route("ai.rewrite") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ content: content })
        })
        .then(response => response.json())
        .then(data => {
            if (data.rewritten) {
                editorInstance.setData(data.rewritten);
                alert('Đã sắp xếp và sửa lại bài viết thành công!');
            } else {
                alert('Có lỗi xảy ra: ' + (data.error || 'AI không trả về kết quả.'));
            }
        })
        .catch(err => {
            console.error(err);
            alert('Lỗi kết nối AI.');
        })
        .finally(() => {
            btn.disabled = false;
            loading.classList.add('d-none');
        });
    });
</script>
@endsection

