<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Str;

class PostController extends Controller
{
    // Hiển thị form tạo bài viết
    public function create() {
        return view('admin.create');
    }

    // Lưu bài viết vào Database
    public function store(Request $request) {
        Post::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'content' => $request->content,
            'image' => $request->image,
            'category' => $request->category,
        ]);

        return redirect('/admin/posts')->with('success', 'Đăng bài thành công!');
    }

    public function destroy($id) {
    $post = Post::findOrFail($id);
    $post->delete();
    return redirect('/admin/posts')->with('success', 'Đã xóa bài viết thành công!');
}
    public function edit($id) {
    $post = Post::findOrFail($id);
    return view('admin.edit', compact('post'));
}

    public function update(Request $request, $id) {
    $post = Post::findOrFail($id);
    $post->update([
        'title' => $request->title,
        'description' => $request->description,
        'content' => $request->content,
        'image' => $request->image,
        'category' => $request->category,
    ]);
    return redirect('/admin/posts')->with('success', 'Cập nhật thành công!');
}

}
