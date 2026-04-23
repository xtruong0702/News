<?php

use Illuminate\Support\Facades\Route;
use App\Models\Post;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Bình luận (Chỉ cho user đã đăng nhập)
Route::post('/comments', [\App\Http\Controllers\CommentController::class, 'store'])->middleware('auth')->name('comments.store');




/*
|--------------------------------------------------------------------------
| Web Routes (Giao diện cho người dùng đọc tin)
|--------------------------------------------------------------------------
*/

// Trang chủ
Route::get('/', function () {
    $posts = Post::latest()->paginate(12);
    $trendingPosts = Post::orderBy('views', 'desc')->take(5)->get();
    return view('home', compact('posts', 'trendingPosts'));
});




// Trang chi tiết bài viết
Route::get('/article/{slug}', function ($slug) {
    $post = Post::where('slug', $slug)->with('comments.user')->firstOrFail();
    $post->increment('views'); // Tăng lượt xem
    return view('article', compact('post'));
});


// Trang chuyên mục (Đã đưa ra ngoài prefix admin và gộp logic urldecode)
Route::get('/category/{name}', function ($name) {
    // Decode để hiểu được tiếng Việt có dấu và khoảng trắng
    $decodedName = rawurldecode($name);
    $posts = Post::where('category', $decodedName)->latest()->get();
    return view('category', compact('posts', 'name'));
})->where('name', '.*');


/*
|--------------------------------------------------------------------------
| Admin Routes (Giao diện quản trị)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {

    
    // Dashboard tổng quan
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    });

    // Danh sách bài viết
    Route::get('/posts', function () {
        $posts = Post::latest()->get();
        return view('admin.posts', compact('posts'));
    });

    // Trang tạo bài viết mới (Form)
    Route::get('/posts/create', [PostController::class, 'create']);

    // Xử lý lưu bài viết
    Route::post('/posts', [PostController::class, 'store']);
    
    // Sửa và xóa bài viết (Để dành cho các bước sau)
    // Route::get('/posts/{id}/edit', [PostController.class, 'edit']);
    // Route::delete('/posts/{id}', [PostController.class, 'destroy']);

    Route::delete('/posts/{id}', [PostController::class, 'destroy']);
    Route::get('/posts/{id}/edit', [PostController::class, 'edit']);
    Route::put('/posts/{id}', [PostController::class, 'update']);

    Route::get('/search', function (Illuminate\Http\Request $request) {
    $keyword = $request->query('query');
    $posts = Post::where('title', 'LIKE', "%{$keyword}%")->latest()->get();
    return view('home', compact('posts')); // Dùng chung view home để hiện kết quả
});
});