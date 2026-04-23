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
                    <form action="/admin/posts" method="POST">
                        @csrf <div class="mb-3">
                            <label class="form-label fw-bold">Tiêu đề bài viết</label>
                            <input type="text" name="title" class="form-control" placeholder="Nhập tiêu đề hấp dẫn..." required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Chuyên mục</label>
                                <select name="category" class="form-select">
                                    <option value="Công nghệ">Công nghệ</option>
                                    <option value="Thế giới">Thế giới</option>
                                    <option value="Kinh doanh">Kinh doanh</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Link hình ảnh (URL)</label>
                                <input type="text" name="image" class="form-control" placeholder="https://example.com/image.jpg">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Mô tả ngắn</label>
                            <textarea name="description" class="form-control" rows="2" placeholder="Tóm tắt bài viết trong 2 câu..."></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Nội dung chi tiết</label>
                            <textarea id="tinymce-editor" name="content" class="form-control" rows="15" placeholder="Viết nội dung tại đây..."></textarea>
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
    ClassicEditor
        .create(document.querySelector('#tinymce-editor'), {
            toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'insertTable', 'undo', 'redo' ]
        })
        .catch(error => {
            console.error(error);
        });
</script>
@endsection
