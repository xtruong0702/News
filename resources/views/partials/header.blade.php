<header class="sticky-header">
    <nav class="navbar navbar-expand-lg py-3 container">
        <div class="container-fluid px-0">
            {{-- Logo Gradient --}}
            <a class="navbar-brand m-0 d-flex align-items-center" href="/">
                <div class="bg-gradient-primary rounded-circle p-2 me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="bi bi-newspaper text-white fs-5"></i>
                </div>
                <span class="fs-4 fw-black" style="background: linear-gradient(135deg, var(--primary-color), var(--accent-color)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    NEWS 24H
                </span>
            </a>
            
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="bi bi-list fs-1 text-dark"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 fw-semibold">
                    <li class="nav-item"><a class="nav-link px-3 transition-hover hover-text-primary" href="/">Trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link px-3 transition-hover hover-text-primary" href="/category/Thời trang">Thời trang</a></li>
                    <li class="nav-item"><a class="nav-link px-3 transition-hover hover-text-primary" href="/category/Làm đẹp">Làm đẹp</a></li>
                    <li class="nav-item"><a class="nav-link px-3 transition-hover hover-text-primary" href="/category/Sống khỏe">Sống khỏe</a></li>
                    <li class="nav-item"><a class="nav-link px-3 transition-hover hover-text-primary" href="/category/Công nghệ">Công nghệ</a></li>
                </ul>
                
                <div class="d-flex align-items-center gap-3 mt-3 mt-lg-0">
                    {{-- Search Bar Bo tròn --}}
                    <form action="{{ route('search') }}" method="GET" class="position-relative d-none d-md-block">
                        <input name="query" class="form-control rounded-pill ps-4 pe-5 border-0 bg-light" type="search" placeholder="Tìm kiếm tin tức..." style="width: 250px;">
                        <button type="submit" class="btn position-absolute end-0 top-50 translate-middle-y border-0 text-muted hover-text-primary">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>

                    @auth
                        <div class="dropdown">
                            <button class="btn btn-light rounded-pill px-3 py-2 d-flex align-items-center gap-2 border shadow-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" class="rounded-circle" width="24" height="24">
                                <span class="fw-bold small">{{ Auth::user()->name }}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-4 mt-2">
                                @if(Auth::user()->role === 'admin' || Auth::user()->role === 'writer')
                                    <li>
                                        <a class="dropdown-item py-2" href="/admin/dashboard">
                                            @if(Auth::user()->role === 'admin')
                                                <i class="bi bi-speedometer2 me-2 text-primary"></i>Quản trị hệ thống
                                            @else
                                                <i class="bi bi-pen me-2 text-indigo" style="color: #4F46E5;"></i>Writer Studio
                                            @endif
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                @endif
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item py-2 text-danger"><i class="bi bi-box-arrow-right me-2"></i>Đăng xuất</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="/login" class="btn btn-outline-primary rounded-pill px-4 fw-bold">Đăng nhập</a>
                        <a href="/register" class="btn bg-gradient-primary rounded-pill px-4 fw-bold shadow-sm">Đăng ký</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
</header>
 