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
    $posts = Post::where('status', 'published')->latest()->paginate(12);
    $trendingPosts = Post::where('status', 'published')->orderBy('views', 'desc')->take(5)->get();
    return view('home', compact('posts', 'trendingPosts'));
});

// Trang chi tiết bài viết
Route::get('/article/{slug}', function ($slug) {
    $post = Post::where('slug', $slug)->with('comments.user')->firstOrFail();
    
    // Nếu bài chưa duyệt, chỉ admin hoặc tác giả mới được xem
    if ($post->status !== 'published') {
        if (!auth()->check() || (auth()->user()->role !== 'admin' && auth()->user()->id !== $post->user_id)) {
            abort(404);
        }
    }

    $post->increment('views'); // Tăng lượt xem
    return view('article', compact('post'));
});

// Trang tìm kiếm (Công khai)
Route::get('/search', [PostController::class, 'search'])->name('search');


// Trang chuyên mục (Đã đưa ra ngoài prefix admin và gộp logic urldecode)
Route::get('/category/{name}', function ($name) {
    // Decode để hiểu được tiếng Việt có dấu và khoảng trắng
    $decodedName = rawurldecode($name);
    $posts = Post::where('category', $decodedName)
                ->where('status', 'published')
                ->latest()->get();
    return view('category', compact('posts', 'name'));
})->where('name', '.*');


/*
|--------------------------------------------------------------------------
| Admin Routes (Giao diện quản trị)
|--------------------------------------------------------------------------
*/

// Các Route AI
Route::post('/ai/summarize', [\App\Http\Controllers\AIController::class, 'summarize'])->name('ai.summarize');
Route::post('/ai/tts', [\App\Http\Controllers\AIController::class, 'tts'])->name('ai.tts');

// Route để sinh data tự động (Chỉ dùng cho mục đích Test)
Route::get('/generate-posts', function (\Illuminate\Http\Request $request) {
    $count = $request->query('count', 50);
    $append = $request->query('append', false);
    
    // Nếu không phải chế độ append (cộng dồn), thì mới xóa bài cũ
    if (!$append) {
        \App\Models\Post::where('image', 'like', '%picsum.photos/seed%')->delete();
    }
    
    \App\Models\Post::factory()->count((int)$count)->create();
    
    $message = $append ? "Đã đăng thêm thành công {$count} bài báo mới!" : "Đã làm mới toàn bộ và tạo thành công {$count} bài báo mới!";
    return redirect('/')->with('success', $message);
});

// Admin Routes (Yêu cầu đăng nhập và quyền Admin)
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::post('/ai/suggest', [\App\Http\Controllers\AIController::class, 'suggest'])->name('ai.suggest');
    Route::post('/ai/rewrite', [\App\Http\Controllers\AIController::class, 'rewrite'])->name('ai.rewrite');

    
    // Dashboard tổng quan
    Route::get('/dashboard', function () {
        $pendingCount = Post::where('status', 'pending')->count();
        return view('admin.dashboard', compact('pendingCount'));
    });

    // Danh sách bài viết
    Route::get('/posts', function (\Illuminate\Http\Request $request) {
        $user = auth()->user();
        $status = $request->query('status');

        $query = Post::with('user')->latest();

        // Admin thấy hết, Writer chỉ thấy bài mình viết
        if ($user->role !== 'admin') {
            $query->where('user_id', $user->id);
        }

        // Lọc theo trạng thái nếu có
        if ($status) {
            $query->where('status', $status);
        }

        $posts = $query->get();
        return view('admin.posts', compact('posts'));
    });

    // Trang tạo bài viết mới (Form)
    Route::get('/posts/create', [PostController::class, 'create']);

    // Xử lý lưu bài viết
    Route::post('/posts', [PostController::class, 'store']);
    
    Route::delete('/posts/{id}', [PostController::class, 'destroy']);
    Route::get('/posts/{id}/edit', [PostController::class, 'edit']);
    Route::put('/posts/{id}', [PostController::class, 'update']);
    Route::post('/posts/{id}/approve', [PostController::class, 'approve'])->name('posts.approve');

    // Quản lý người dùng (Chỉ cho Admin)
    Route::get('/users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::post('/users/{id}/role', [\App\Http\Controllers\UserController::class, 'updateRole'])->name('users.updateRole');
});