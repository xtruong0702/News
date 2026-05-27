<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - News Portal</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #6366f1; /* Indigo */
            --accent-color: #a855f7;  /* Purple */
            --bg-light: #f8fafc;
            --text-main: #334155;
            --text-heading: #0f172a;
        }

        body {
            font-family: 'Outfit', sans-serif;
            color: var(--text-main);
            background-color: var(--bg-light);
            line-height: 1.6;
        }

        h1, h2, h3, .navbar-brand, .heading-font {
            font-family: 'Playfair Display', serif;
            color: var(--text-heading);
            font-weight: 700;
        }

        .bg-gradient-primary { 
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
            color: white;
        }
        
        /* Hiệu ứng Hover mượt mà */
        .card-news {
            border: none;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            border-radius: 16px;
            overflow: hidden;
            background: white;
        }
        .card-news:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(99, 102, 241, 0.1);
        }

        .sticky-header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }

        /* Utility classes để cắt chữ (Chống tràn chữ) */
        .line-clamp-1 { display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; }
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
        
        .transition-hover { transition: all 0.3s ease; }
        .hover-text-primary:hover { color: var(--primary-color) !important; }
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