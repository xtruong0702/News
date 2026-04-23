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
                    <form action="{{ url('/admin/posts/'.$post->id) }}" method="POST">
                        @csrf 
                        @method('PUT') <div class="mb-3">
                            <label class="form-label fw-bold">Tiêu đề bài viết</label>
                            <input type="text" name="title" class="form-control" value="{{ $post->title }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Chuyên mục</label>
                                <select name="category" class="form-select">
                                    <option value="Công nghệ" {{ $post->category == 'Công nghệ' ? 'selected' : '' }}>Công nghệ</option>
                                    <option value="Thế giới" {{ $post->category == 'Thế giới' ? 'selected' : '' }}>Thế giới</option>
                                    <option value="Kinh doanh" {{ $post->category == 'Kinh doanh' ? 'selected' : '' }}>Kinh doanh</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Link hình ảnh (URL)</label>
                                <input type="text" name="image" class="form-control" value="{{ $post->image }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Mô tả ngắn</label>
                            <textarea name="description" class="form-control" rows="2">{{ $post->description }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nội dung chi tiết</label>
                            <textarea id="tinymce-editor" name="content" class="form-control" rows="15">{{ $post->content }}</textarea>
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
    ClassicEditor
        .create(document.querySelector('#tinymce-editor'), {
            toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'insertTable', 'undo', 'redo' ]
        })
        .catch(error => {
            console.error(error);
        });
</script>
@endsection
