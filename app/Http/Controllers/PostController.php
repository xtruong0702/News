<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    // Hiển thị form tạo bài viết
    public function create() {
        return view('admin.create');
    }

    // Lưu bài viết vào Database
    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048', 
            'description' => 'required|string|max:500', 
            'content' => 'required|string',
        ]);

        $user = auth()->user();
        
        $data = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'description' => $request->description,
            'content' => $request->content,
            'category' => $request->category,
            'user_id' => $user->id,
            // Admin đăng thì được duyệt luôn, Writer đăng thì chờ duyệt
            'status' => ($user->role === 'admin') ? 'published' : 'pending',
        ];

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('posts', 'public');
            $data['image'] = $path;
        }

        Post::create($data);

        return redirect('/admin/posts')->with('success', 'Đăng bài thành công! ' . ($user->role === 'writer' ? 'Vui lòng chờ Admin duyệt bài.' : ''));
    }

    public function destroy($id) {
        $post = Post::findOrFail($id);
        $user = auth()->user();

        // Kiểm tra quyền: Chỉ admin hoặc chính tác giả mới được xóa
        if ($user->role !== 'admin' && $post->user_id !== $user->id) {
            return back()->with('error', 'Bạn không có quyền xóa bài viết này.');
        }
        
        if ($post->image && !str_starts_with($post->image, 'http')) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();
        return redirect('/admin/posts')->with('success', 'Đã xóa bài viết thành công!');
    }

    public function edit($id) {
        $post = Post::findOrFail($id);
        $user = auth()->user();

        // Writer không được sửa bài của người khác
        if ($user->role !== 'admin' && $post->user_id !== $user->id) {
            return redirect('/admin/posts')->with('error', 'Bạn không có quyền sửa bài này.');
        }

        // Writer không được sửa bài đã được duyệt
        if ($user->role === 'writer' && $post->status === 'published') {
            return redirect('/admin/posts')->with('error', 'Bài viết đã được duyệt, bạn không thể chỉnh sửa.');
        }

        return view('admin.edit', compact('post'));
    }

    public function update(Request $request, $id) {
        $post = Post::findOrFail($id);
        $user = auth()->user();

        if ($user->role !== 'admin' && $post->user_id !== $user->id) {
            return redirect('/admin/posts')->with('error', 'Bạn không có quyền cập nhật bài này.');
        }

        if ($user->role === 'writer' && $post->status === 'published') {
            return redirect('/admin/posts')->with('error', 'Bài viết đã được duyệt, bạn không thể chỉnh sửa.');
        }
        
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', 
            'description' => 'required|string|max:500', 
            'content' => 'required|string',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'category' => $request->category,
        ];

        if ($request->hasFile('image')) {
            if ($post->image && !str_starts_with($post->image, 'http')) {
                Storage::disk('public')->delete($post->image);
            }
            
            $path = $request->file('image')->store('posts', 'public');
            $data['image'] = $path;
        }

        $post->update($data);
        return redirect('/admin/posts')->with('success', 'Cập nhật thành công!');
    }

    // Admin duyệt bài
    public function approve($id) {
        if (auth()->user()->role !== 'admin') {
            return back()->with('error', 'Chỉ Admin mới có quyền duyệt bài.');
        }

        $post = Post::findOrFail($id);
        $post->update(['status' => 'published']);

        return back()->with('success', 'Đã duyệt bài viết thành công!');
    }

    // Chức năng tìm kiếm
    public function search(Request $request) {
        $query = $request->input('query');
        
        $posts = Post::where('status', 'published') // Chỉ tìm bài đã đăng
                    ->where(function($q) use ($query) {
                        $q->where('title', 'LIKE', "%{$query}%")
                          ->orWhere('description', 'LIKE', "%{$query}%");
                    })
                    ->latest()
                    ->paginate(12);

        return view('search', compact('posts', 'query'));
    }

}
