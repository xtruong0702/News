<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - News Portal</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&family=Merriweather:wght@400;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #1E3A8A; /* Màu xanh đậm hiện đại */
            --accent-color: #B91C1C;  /* Màu đỏ nhấn mạnh */
            --bg-light: #F8F9FA;
            --text-main: #333333;
        }

        body {
            font-family: 'Merriweather', serif; /* Tối ưu cho trải nghiệm đọc */
            color: var(--text-main);
            line-height: 1.6;
        }

        h1, h2, h3, .navbar-brand {
            font-family: 'Inter', sans-serif;
            font-weight: 700;
        }

        .bg-primary-custom { background-color: var(--primary-color); }
        
        /* Hiệu ứng Hover cho Card như bạn yêu cầu */
        .card-news {
            border: none;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .card-news:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .sticky-header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: white;
            border-bottom: 1px solid #eee;
        }
    </style>
</head>
<body>

    @include('partials.header')

    <main class="container py-4">
        @yield('content')
    </main>

    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>