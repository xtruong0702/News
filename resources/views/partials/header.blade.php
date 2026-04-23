<header class="sticky-header shadow-sm">
    <nav class="navbar navbar-expand-lg navbar-light container">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold text-primary" href="/" style="font-size: 24px;">
                <span style="color: var(--accent-color);">DAILY</span>NEWS
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="/">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="/category/Thời trang">Thời trang</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="/category/Làm đẹp">Làm đẹp</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="/category/Sống khỏe">Sống khỏe</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="/category/Công nghệ">Công nghệ</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="/category/Thế giới">Thế giới</a></li>

                </ul>
                
                <div class="d-flex align-items-center">
                    <form action="/search" method="GET" class="d-flex align-items-center">
    <input name="query" class="form-control me-2 form-control-sm" type="search" placeholder="Tìm kiếm tin tức...">
    <button type="submit" class="btn btn-sm btn-outline-dark">Tìm</button>
</form>
                    <button class="btn btn-sm btn-outline-dark me-2">Dark</button>
                    @auth
                        <span class="me-3 text-muted small">
                            <i class="bi bi-person-circle me-1"></i>Chào, <strong>{{ Auth::user()->name }}</strong>
                        </span>
                        @if(Auth::user()->role === 'admin')
                            <a href="/admin/dashboard" class="btn btn-sm btn-outline-primary me-2">Dashboard</a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger">Đăng xuất</button>
                        </form>
                    @else

                        <a href="/login" class="btn btn-sm btn-outline-primary me-2">Đăng nhập</a>
                        <a href="/register" class="btn btn-sm btn-primary">Đăng ký</a>
                    @endauth


                </div>
            </div>
        </div>
    </nav>
</header> 