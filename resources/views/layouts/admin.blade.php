<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root { 
            --sidebar-width: 250px; 
            --primary-admin: {{ Auth::user()->role === 'admin' ? '#1E3A8A' : '#4F46E5' }}; 
        }
        body { background-color: #f4f6f9; font-family: 'Inter', sans-serif; }
        #sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            background: var(--primary-admin);
            color: white;
            transition: all 0.3s;
            background-image: linear-gradient(180deg, var(--primary-admin) 0%, {{ Auth::user()->role === 'admin' ? '#1e40af' : '#6366f1' }} 100%);
        }
        #sidebar .nav-link { color: rgba(255,255,255,0.8); margin-bottom: 5px; }
        #sidebar .nav-link:hover, #sidebar .nav-link.active { background: rgba(255,255,255,0.1); color: white; border-radius: 5px; }
        #main-content { margin-left: var(--sidebar-width); padding: 20px; }
        .card-stats { border: none; border-radius: 10px; transition: transform 0.2s; }
        .card-stats:hover { transform: translateY(-5px); }
    </style>
</head>
<body>

    <div id="sidebar" class="p-3 shadow">
        <h3 class="text-center fw-bold mb-4">
            @if(Auth::user()->role === 'admin')
                <i class="bi bi-shield-lock me-2"></i>NEWS ADMIN
            @else
                <i class="bi bi-pen me-2"></i>WRITER STUDIO
            @endif
        </h3>
        <hr>
        <ul class="nav flex-column">
            <li class="nav-item"><a href="/admin/dashboard" class="nav-link {{ Request::is('admin/dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a></li>
            <li class="nav-item"><a href="/admin/posts" class="nav-link {{ Request::is('admin/posts*') ? 'active' : '' }}"><i class="bi bi-file-earmark-post me-2"></i> Bài viết</a></li>
            <li class="nav-item"><a href="#" class="nav-link"><i class="bi bi-grid me-2"></i> Chuyên mục</a></li>
            @if(Auth::user()->role === 'admin')
            <li class="nav-item"><a href="/admin/users" class="nav-link {{ Request::is('admin/users*') ? 'active' : '' }}"><i class="bi bi-people me-2"></i> Người dùng</a></li>
            @endif
            <li class="nav-item mt-5"><a href="/" class="nav-link text-warning"><i class="bi bi-arrow-left-circle me-2"></i> Xem Website</a></li>
        </ul>
    </div>

    <div id="main-content">
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm rounded mb-4 px-3">
            <span class="navbar-brand mb-0 h1">Quản lý hệ thống</span>
            <div class="ms-auto">
                <span class="me-3">Xin chào, <strong>{{ Auth::user()->name }}</strong> ({{ Auth::user()->role }})</span>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger">Đăng xuất</button>
                </form>
            </div>
        </nav>
        
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>