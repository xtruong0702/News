<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Http\Exceptions\HttpResponseException;

class CategoryController extends Controller
{
    /**
     * Kiểm tra quyền Admin an toàn trong vòng đời request của Laravel.
     * Ném ra HttpResponseException để dừng thực thi và chuyển hướng ngay lập tức.
     */
    private function checkAdmin()
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            $response = redirect('/admin/dashboard')->with('error', 'Bạn không có quyền quản lý chuyên mục.');
            throw new HttpResponseException($response);
        }
    }

    /**
     * Hiển thị danh sách chuyên mục
     */
    public function index()
    {
        $this->checkAdmin();
        $categories = Category::withCount('posts')->latest()->get();
        $posts = Post::with(['user', 'comments'])->latest()->get();
        return view('admin.categories.index', compact('categories', 'posts'));
    }

    /**
     * Lưu chuyên mục mới
     */
    public function store(Request $request)
    {
        $this->checkAdmin();

        $request->validate([
            'name' => 'required|string|max:100|unique:categories,name',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('categories.index')->with('success', 'Thêm chuyên mục mới thành công!');
    }

    /**
     * Hiển thị form chỉnh sửa chuyên mục
     */
    public function edit($id)
    {
        $this->checkAdmin();
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Cập nhật chuyên mục
     */
    public function update(Request $request, $id)
    {
        $this->checkAdmin();
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100|unique:categories,name,' . $id,
            'slug' => 'required|string|max:100|unique:categories,slug,' . $id,
        ]);

        $oldName = $category->name;
        $newName = $request->name;

        // Cập nhật tất cả bài viết cũ sang tên chuyên mục mới để tránh mất liên kết
        if ($oldName !== $newName) {
            Post::where('category', $oldName)->update(['category' => $newName]);
        }

        $category->update([
            'name' => $newName,
            'slug' => Str::slug($request->slug),
        ]);

        return redirect()->route('categories.index')->with('success', 'Cập nhật chuyên mục thành công!');
    }

    /**
     * Xóa chuyên mục
     */
    public function destroy($id)
    {
        $this->checkAdmin();
        $category = Category::findOrFail($id);

        // Kiểm tra xem chuyên mục có bài viết nào không
        $postCount = Post::where('category', $category->name)->count();
        if ($postCount > 0) {
            return back()->with('error', "Không thể xóa chuyên mục này vì đang có {$postCount} bài viết trực thuộc!");
        }

        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Xóa chuyên mục thành công!');
    }
}
