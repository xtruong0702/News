@extends('layouts.admin')

@section('title', 'Chỉnh sửa Chuyên mục')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-pencil-square me-2 text-primary"></i>Chỉnh sửa Chuyên mục</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('categories.update', $category->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold text-secondary">Tên chuyên mục</label>
                            <input type="text" id="category-name" name="name" class="form-control rounded-3 py-2 @error('name') is-invalid @enderror" value="{{ old('name', $category->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-secondary">Đường dẫn tĩnh (Slug)</label>
                            <input type="text" id="category-slug" name="slug" class="form-control rounded-3 py-2 @error('slug') is-invalid @enderror" value="{{ old('slug', $category->slug) }}" required>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted d-block mt-2">Được tạo tự động, không dấu và khoảng trắng. Ví dụ: <code>thoi-trang</code></small>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('categories.index') }}" class="btn btn-light py-2 px-4 rounded-3 fw-bold">Quay lại</a>
                            <button type="submit" class="btn btn-primary py-2 px-4 rounded-3 fw-bold shadow-sm">
                                <i class="bi bi-save me-2"></i>Cập nhật
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Tự động tạo slug khi thay đổi tên (chỉ khi slug chưa được chỉnh sửa thủ công nhiều)
    const nameInput = document.getElementById('category-name');
    const slugInput = document.getElementById('category-slug');

    nameInput.addEventListener('input', function() {
        slugInput.value = convertToSlug(this.value);
    });

    function convertToSlug(str) {
        // Chuyển về ký tự thường
        let slug = str.toLowerCase();
        // Chuyển ký tự có dấu thành không dấu
        slug = slug.replace(/á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
        slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
        slug = slug.replace(/í|ì|ỉ|ĩ|ị/gi, 'i');
        slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
        slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
        slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
        slug = slug.replace(/đ/gi, 'd');
        // Xóa ký tự đặc biệt
        slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
        // Thay khoảng trắng bằng ký tự gạch ngang
        slug = slug.replace(/ /gi, "-");
        // Gom nhiều ký tự gạch ngang liên tiếp thành 1
        slug = slug.replace(/\-\-\-\-\-/gi, '-');
        slug = slug.replace(/\-\-\-\-/gi, '-');
        slug = slug.replace(/\-\-\-/gi, '-');
        slug = slug.replace(/\-\-/gi, '-');
        // Xóa ký tự gạch ngang ở đầu và cuối
        slug = '@' + slug + '@';
        slug = slug.replace(/\@\-|\-\@|\@/gi, '');
        return slug;
    }
</script>
@endsection
