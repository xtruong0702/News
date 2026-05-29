@extends('layouts.admin')

@section('title', 'Thêm bài viết mới')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Soạn thảo bài viết mới</h5>
                </div>
                <div class="card-body">
                    <form action="/admin/posts" method="POST" enctype="multipart/form-data">
                        @csrf 
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tiêu đề bài viết</label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Nhập tiêu đề hấp dẫn..." required>
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Chuyên mục</label>
                                <select name="category" class="form-select">
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->name }}" {{ old('category') == $cat->name ? 'selected' : '' }}>{{ $cat->name }}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Tải lên hình ảnh</label>
                                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                                <small class="text-muted">Định dạng hỗ trợ: JPG, PNG, WEBP (Max 2MB)</small>
                                @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Mô tả ngắn</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="2" placeholder="Tóm tắt bài viết trong 2 câu...">{{ old('description') }}</textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label fw-bold mb-0">Nội dung chi tiết</label>
                                <button type="button" id="ai-suggest-btn" class="btn btn-sm btn-outline-secondary rounded-pill">
                                    <i class="bi bi-robot me-1"></i> AI viết bài giúp bạn
                                </button>
                            </div>
                            <div id="ai-loading" class="small text-primary mb-2 d-none">
                                <span class="spinner-border spinner-border-sm me-2"></span> AI đang suy nghĩ và viết bài...
                            </div>
                            <textarea id="tinymce-editor" name="content" class="form-control @error('content') is-invalid @enderror" rows="15" placeholder="Viết nội dung tại đây...">{{ old('content') }}</textarea>
                            @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>


                        <div class="text-end">
                            <a href="/admin/posts" class="btn btn-light me-2">Hủy</a>
                            <button type="submit" class="btn btn-primary px-4">Đăng bài viết</button>
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

    // AI Suggest Logic
    document.getElementById('ai-suggest-btn').addEventListener('click', function() {
        const description = document.querySelector('textarea[name="description"]').value;
        if (!description || description.trim() === '') {
            alert('Vui lòng nhập mô tả ngắn trước khi dùng AI gợi ý bài viết!');
            return;
        }

        const btn = this;
        const loading = document.getElementById('ai-loading');
        
        btn.disabled = true;
        loading.classList.remove('d-none');

        fetch('{{ route("ai.suggest") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ description: description })
        })
        .then(response => response.json())
        .then(data => {
            if (data.suggestion) {
                editorInstance.setData(data.suggestion);
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
