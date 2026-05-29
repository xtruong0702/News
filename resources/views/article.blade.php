@extends('layouts.master')

@section('title', $post->title)

@section('content')
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Lora:ital,wght@0,400;0,600;1,400&family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">

{{-- Reading Progress Bar --}}
<div id="reading-progress" class="position-fixed top-0 start-0 vh-100" style="width: 4px; background: linear-gradient(to bottom, #6366f1, #a855f7); z-index: 9999; transform: scaleY(0); transform-origin: top;"></div>

<style>
    .btn-ai {
        background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
        color: white;
        border: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }
    .btn-ai:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(99, 102, 241, 0.3);
        color: white;
    }
    .btn-ai:active {
        transform: translateY(0);
    }
    .btn-ai-outline {
        border: 2px solid;
        border-image: linear-gradient(135deg, #6366f1 0%, #a855f7 100%) 1;
        background: transparent;
        color: #6366f1;
        transition: all 0.3s;
    }
    .btn-ai-outline:hover {
        background: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
        color: white;
    }
    
    #ai-summary-box {
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(99, 102, 241, 0.2);
        position: relative;
        z-index: 1;
    }
    #ai-summary-box::before {
        content: '';
        position: absolute;
        top: -2px; left: -2px; right: -2px; bottom: -2px;
        background: linear-gradient(135deg, #6366f1, #a855f7);
        z-index: -1;
        border-radius: 22px;
        opacity: 0.15;
    }

    .pulse-animation {
        animation: pulse-purple 2s infinite;
    }

    @keyframes pulse-purple {
        0% { box-shadow: 0 0 0 0 rgba(168, 85, 247, 0.4); }
        70% { box-shadow: 0 0 0 10px rgba(168, 85, 247, 0); }
        100% { box-shadow: 0 0 0 0 rgba(168, 85, 247, 0); }
    }

    .ai-typing-effect::after {
        content: '|';
        animation: blink 1s infinite;
    }
    @keyframes blink {
        50% { opacity: 0; }
    }
</style>

<div class="row g-5">
    {{-- Cột nội dung chính (Bên trái) --}}
    <article class="col-lg-8 main-article" style="background: white; padding: 40px; border-radius: 24px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
        
        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb small bg-light p-2 rounded-pill px-4">
                <li class="breadcrumb-item"><a href="/" class="text-decoration-none text-muted">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/category/'.$post->category) }}" class="text-decoration-none text-primary fw-bold">{{ $post->category }}</a></li>
                <li class="breadcrumb-item active text-truncate" style="max-width: 200px;" aria-current="page">{{ $post->title }}</li>
            </ol>
        </nav>

        <header class="mb-4">
            <h1 class="display-4 fw-black mb-4 article-title" style="font-family: 'Playfair Display', serif; line-height: 1.2; color: #0f172a;">
                {{ $post->title }}
            </h1>

            <div class="d-flex align-items-center py-3 border-top border-bottom mb-4">
                <div class="position-relative">
                    <img src="https://ui-avatars.com/api/?name=Admin&background=6366f1&color=fff" class="rounded-circle me-3 shadow-sm" width="50" height="50" alt="Author">
                </div>
                <div>
                    <p class="mb-0 fw-bold text-dark">Admin</p>
                    <small class="text-muted">
                        <i class="bi bi-calendar3 me-1"></i> {{ $post->created_at->format('d M, Y') }} 
                        <span class="mx-2">•</span> 
                        <i class="bi bi-eye me-1"></i> {{ number_format($post->views) }} lượt xem
                    </small>
                </div>
                <div class="ms-auto d-flex gap-2">
                    <button class="btn btn-light rounded-circle shadow-sm" title="Lưu bài viết"><i class="bi bi-bookmark"></i></button>
                    <button class="btn btn-light rounded-circle shadow-sm" title="Chia sẻ Facebook"><i class="bi bi-facebook text-primary"></i></button>
                </div>
            </div>
        </header>

        <div class="article-body" style="font-family: 'Lora', serif; font-size: 1.2rem; line-height: 1.9; color: #334155;">
            
            {{-- Main Image (Chuyển lên trên Sapo) --}}
            @if($post->image)
            <figure class="mb-4 text-center">
                <img src="{{ str_starts_with($post->image, 'http') ? $post->image : asset('storage/' . $post->image) }}" class="img-fluid rounded-4 shadow-sm w-100" alt="{{ $post->title }}" style="max-height: 500px; object-fit: cover;">
                <figcaption class="text-muted small italic-text mt-2"><i class="bi bi-camera me-1"></i> Ảnh minh họa</figcaption>
            </figure>
            @endif

            {{-- Sapo / Description --}}
            <div class="lead fw-bold mb-5 ps-4 border-start border-4 border-primary italic-text bg-light p-3 rounded-end-3" style="color: #1e293b; font-size: 1.25rem;">
                {{ $post->description }}
            </div>

            {{-- Real Content --}}
            <div class="content-text first-letter-big">
                {!! $post->content !!}
            </div>
        </div>

        {{-- Tags Section --}}
        <div class="mt-5 pt-4 border-top">
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <span class="fw-bold me-2 text-dark"><i class="bi bi-tags me-1"></i> Tags:</span>
                <a href="#" class="tag-item">#{{ $post->category }}</a>
                <a href="#" class="tag-item">#TinTuc24h</a>
            </div>
        </div>

        {{-- Author Bio Card --}}
        <div class="author-card mt-5 p-4 rounded-4 bg-light d-flex align-items-center shadow-sm">
            <img src="https://ui-avatars.com/api/?name=Admin&background=0f172a&color=fff" class="rounded-circle me-4" width="70" height="70">
            <div>
                <h5 class="fw-bold mb-1">Viết bởi: Admin</h5>
                <p class="text-muted small mb-0">Biên tập viên cao cấp. Chuyên trách phân tích chuyên sâu.</p>
            </div>
        </div>
    </article>

    {{-- Sidebar (Bên phải) --}}
    <div class="col-lg-4">
        <div class="sticky-top" style="top: 100px;">
            
            {{-- Bảng điều khiển AI (Chuyển về Sidebar) --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden ai-sidebar-card">
                <div class="card-header bg-white py-3 border-bottom-0 d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-2 rounded-3 me-3">
                        <i class="fas fa-robot text-primary fs-5"></i>
                    </div>
                    <h5 class="fw-bold m-0 text-dark">AI Trợ lý</h5>
                </div>
                <div class="card-body bg-light p-4">
                    <div id="ai-summary-box" class="mb-4 d-none">
                        <div class="p-3 bg-white rounded-4 shadow-sm border border-primary border-opacity-25 text-secondary small lh-base ai-typing-effect" id="ai-summary-content">
                            <span class="spinner-border spinner-border-sm text-primary me-2"></span> Đang phân tích...
                        </div>
                    </div>
                    
                    <div class="d-grid gap-3">
                        <button id="ai-summarize-btn" class="btn btn-ai rounded-pill py-2 shadow-sm fw-bold">
                            <i class="fas fa-magic me-2"></i> Tóm tắt bài viết
                        </button>
                        <button id="ai-translate-btn" class="btn btn-ai rounded-pill py-2 shadow-sm fw-bold" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);" data-lang="vi">
                            <i class="fas fa-language me-2"></i> <span>Dịch sang Tiếng Anh</span>
                        </button>
                        <button id="tts-btn" class="btn btn-ai-outline rounded-pill py-2 shadow-sm fw-bold">
                            <i class="fas fa-volume-up me-2"></i> <span>Nghe bài báo</span>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Đọc nhiều nhất --}}
            <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                <h5 class="fw-bold mb-4 border-bottom pb-2">Đọc nhiều nhất</h5>
                @php $topPosts = \App\Models\Post::orderBy('views', 'desc')->take(5)->get(); @endphp
                @foreach($topPosts as $tp)
                <div class="mb-3 d-flex align-items-center gap-3">
                    <h2 class="text-black-50 fw-bold opacity-25 m-0" style="font-family: 'Playfair Display', serif;">{{ $loop->iteration }}</h2>
                    <a href="{{ url('/article/'.$tp->slug) }}" class="text-decoration-none text-dark d-flex gap-3 flex-grow-1">
                        <h6 class="small fw-bold mb-0 lh-base hover-primary">{{ Str::limit($tp->title, 55) }}</h6>
                    </a>
                </div>
                @endforeach
            </div>

            {{-- Newsletter --}}
            <div class="card border-0 shadow-lg text-white p-4 rounded-4" style="background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);">
                <h5 class="fw-bold mb-3">Bản tin hàng ngày</h5>
                <p class="small opacity-75">Cập nhật tin tức quan trọng nhất mỗi sáng.</p>
                <div class="input-group">
                    <input type="text" class="form-control border-0 bg-white bg-opacity-10 text-white" placeholder="Email của bạn...">
                    <button class="btn btn-primary"><i class="bi bi-send"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Các thành phần Full-Width ở dưới cùng --}}
<div class="row mt-5">
    <div class="col-12">
        {{-- Tin liên quan --}}
        <section class="py-5 border-top border-bottom mb-5">
            <h3 class="fw-bold mb-4 text-center" style="font-family: 'Playfair Display', serif;">Tin tức cùng chuyên mục</h3>
            <div class="row justify-content-center g-4">
                @php
                    $relatedPosts = \App\Models\Post::where('category', $post->category)->where('id', '!=', $post->id)->take(3)->get();
                @endphp
                @foreach($relatedPosts as $rp)
                <div class="col-md-4">
                    <div class="card border-0 h-100 related-post-card shadow-sm rounded-4 overflow-hidden">
                        <a href="{{ url('/article/'.$rp->slug) }}" class="text-decoration-none text-dark">
                            <img src="{{ $rp->image ? (str_starts_with($rp->image, 'http') ? $rp->image : asset('storage/' . $rp->image)) : 'https://picsum.photos/id/50/400/250' }}" class="card-img-top" alt="{{ $rp->title }}" style="height: 200px; object-fit: cover;">
                            <div class="card-body p-4">
                                <span class="badge bg-primary bg-opacity-10 text-primary mb-2">{{ $rp->category }}</span>
                                <h5 class="fw-bold lh-base mb-0">{{ Str::limit($rp->title, 60) }}</h5>
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </section>

        {{-- Hệ thống Bình luận --}}
        <section class="col-lg-8 mx-auto" id="comments">
            <div class="d-flex align-items-center justify-content-between mb-5">
                <h3 class="fw-bold m-0" style="font-family: 'Playfair Display', serif;">Bình luận ({{ $post->comments->count() }})</h3>
                <div class="badge bg-primary rounded-pill px-3 py-2 fs-6">{{ $post->comments->count() }} thảo luận</div>
            </div>

            @auth
                <div class="card border-0 shadow-sm mb-5 rounded-4 overflow-hidden">
                    <div class="card-body p-4 bg-light">
                        <form action="{{ route('comments.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <div class="d-flex gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=6366f1&color=fff" class="rounded-circle shadow-sm" width="50" height="50">
                                <div class="flex-grow-1">
                                    <textarea name="content" class="form-control border-0 shadow-none bg-white p-3 rounded-4" rows="3" placeholder="Chia sẻ góc nhìn của bạn..." required></textarea>
                                    <div class="text-end mt-3">
                                        <button type="submit" class="btn btn-primary px-5 rounded-pill fw-bold">Đăng bình luận <i class="bi bi-send ms-2"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <div class="text-center py-5 bg-light rounded-4 mb-5 border-dashed">
                    <i class="bi bi-chat-left-dots display-4 text-primary opacity-50 mb-3 d-block"></i>
                    <h5 class="fw-bold text-dark">Tham gia cuộc thảo luận</h5>
                    <p class="text-muted">Bạn cần đăng nhập để chia sẻ ý kiến của mình với cộng đồng.</p>
                    <a href="/login" class="btn btn-primary px-5 rounded-pill shadow-sm">Đăng nhập ngay</a>
                </div>
            @endauth

            <div class="comment-list">
                @foreach($post->comments as $comment)
                <div class="d-flex mb-4 p-4 rounded-4 comment-bubble shadow-sm">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->user->name) }}&background=random" class="rounded-circle me-3 shadow-sm" width="50" height="50" alt="Avatar">
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="mb-0 fw-bold text-dark">{{ $comment->user->name }}</h6>
                            <small class="text-muted fw-bold">{{ $comment->created_at->diffForHumans() }}</small>
                        </div>
                        <div class="comment-text-box">
                            {{ $comment->content }}
                        </div>
                    </div>
                </div>
                @endforeach

                @if($post->comments->count() == 0)
                    <div class="text-center py-5 opacity-50 bg-light rounded-4 border-dashed">
                        <i class="bi bi-inbox display-4 mb-3 d-block"></i>
                        <p class="fw-bold">Chưa có bình luận nào.</p>
                        <p class="small">Hãy là người đầu tiên chia sẻ suy nghĩ của bạn!</p>
                    </div>
                @endif
            </div>
        </section>
    </div>
</div>


<style>
    body { font-family: 'Outfit', sans-serif; background-color: #f1f5f9; }
    .x-small { font-size: 0.75rem; }
    .italic-text { font-style: italic; }
    .fw-black { font-weight: 900; }
    
    .article-title { color: #1e293b; letter-spacing: -1px; }
    .tag-item { 
        background: #e2e8f0; color: #475569; padding: 5px 15px; 
        border-radius: 50px; text-decoration: none; font-size: 0.8rem; font-weight: 600;
        transition: all 0.3s;
    }
    .tag-item:hover { background: #6366f1; color: white; transform: translateY(-2px); }

    .first-letter-big:first-letter {
        float: left; font-family: 'Playfair Display', serif;
        font-size: 5rem; line-height: 1; font-weight: 900;
        padding-right: 15px; color: #6366f1;
    }

    .comment-bubble { background: #fff; transition: transform 0.3s; border: 1px solid #f1f5f9; }
    .comment-bubble:hover { transform: translateX(10px); background: #f8fafc; }
    .comment-text-box { font-family: 'Lora', serif; font-size: 1.1rem; line-height: 1.6; color: #475569; }

    .border-dashed { border: 2px dashed #e2e8f0; }
    .related-post-card img { transition: 0.5s; }
    .related-post-card:hover img { transform: scale(1.05); }
    .hover-primary:hover { color: #6366f1 !important; }
</style>

<script>
    // Xử lý thanh Reading Progress
    window.onscroll = function() {
        let winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        let height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        let scrolled = (winScroll / height);
        document.getElementById("reading-progress").style.transform = "scaleY(" + scrolled + ")";
    };

    // --- AI Summarize Logic ---
    document.getElementById('ai-summarize-btn').addEventListener('click', function() {
        const summarizeBtn = this;
        const box = document.getElementById('ai-summary-box');
        const contentArea = document.getElementById('ai-summary-content');
        
        box.classList.remove('d-none');
        summarizeBtn.disabled = true;
        summarizeBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Đang tóm tắt...';
        
        const articleText = document.querySelector('.content-text').innerText;

        fetch('{{ route("ai.summarize") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ content: articleText })
        })
        .then(response => response.json())
        .then(data => {
            contentArea.classList.remove('ai-typing-effect');
            if (data.summary) {
                contentArea.innerText = data.summary;
                summarizeBtn.innerHTML = '<i class="fas fa-check me-2"></i> Đã tóm tắt';
            } else {
                contentArea.innerText = 'Lỗi: ' + (data.error || 'Không thể tóm tắt.');
                summarizeBtn.innerHTML = '<i class="fas fa-sparkles me-2"></i> Thử lại';
                summarizeBtn.disabled = false;
            }
        })
        .catch(err => {
            contentArea.innerText = 'Lỗi kết nối AI.';
            summarizeBtn.disabled = false;
        });
    });

    // --- TTS Logic (FPT AI TTS) ---
    const ttsBtn = document.getElementById('tts-btn');
    let audio = null;
    let isSpeaking = false;

    ttsBtn.addEventListener('click', function() {
        if (isSpeaking) {
            resetTtsBtn();
            return;
        }

        const articleText = document.querySelector('.content-text').innerText;
        
        ttsBtn.disabled = true;
        ttsBtn.classList.add('pulse-animation');
        ttsBtn.querySelector('span').innerText = 'Đang kết nối...';

        fetch('{{ route("ai.tts") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ text: articleText })
        })
        .then(response => response.json())
        .then(data => {
            if (data.async && data.error == 0) {
                playFptAudio(data.async);
            } else {
                alert('FPT AI báo lỗi: ' + (data.message || 'Không rõ nguyên nhân'));
                resetTtsBtn();
            }
        })
        .catch(err => {
            alert('Lỗi kết nối Server.');
            resetTtsBtn();
        });
    });

    function playFptAudio(url) {
        const ttsIcon = ttsBtn.querySelector('i');
        const ttsText = ttsBtn.querySelector('span');

        ttsText.innerText = 'Đang xử lý...';

        let attempts = 0;
        const maxAttempts = 30;
        
        const checkAudioReady = setInterval(() => {
            attempts++;
            
            const tempAudio = new Audio(url);
            tempAudio.addEventListener('canplaythrough', () => {
                clearInterval(checkAudioReady);
                audio = tempAudio;
                audio.play();
                isSpeaking = true;
                ttsBtn.disabled = false;
                ttsBtn.classList.remove('btn-ai-outline', 'pulse-animation');
                ttsBtn.classList.add('btn-danger');
                ttsIcon.className = 'fas fa-stop me-2';
                ttsText.innerText = 'Dừng nghe';
                
                audio.onended = function() {
                    resetTtsBtn();
                };
            }, { once: true });

            tempAudio.addEventListener('error', () => {
                if (attempts >= maxAttempts) {
                    clearInterval(checkAudioReady);
                    alert('FPT AI đang bận hoặc bài viết quá dài. Vui lòng thử lại sau ít phút.');
                    resetTtsBtn();
                }
            }, { once: true });

        }, 1000);
    }

    function resetTtsBtn() {
        isSpeaking = false;
        ttsBtn.disabled = false;
        ttsBtn.classList.remove('pulse-animation', 'btn-danger');
        ttsBtn.classList.add('btn-ai-outline');
        ttsBtn.querySelector('i').className = 'fas fa-volume-up me-2';
        ttsBtn.querySelector('span').innerText = 'Nghe bài';
        if (audio) {
            audio.pause();
            audio = null;
        }
    }

    // Hủy đọc khi rời trang
    window.onbeforeunload = function() {
        if (audio) audio.pause();
    };

    // --- AI Translate Logic ---
    const translateBtn = document.getElementById('ai-translate-btn');
    if (translateBtn) {
        const articleTitle = document.querySelector('.article-title');
        const articleSapo = document.querySelector('.lead');
        const contentText = document.querySelector('.content-text');
        
        const originalContent = {
            title: articleTitle ? articleTitle.innerText : '',
            sapo: articleSapo ? articleSapo.innerText : '',
            content: contentText ? contentText.innerHTML : ''
        };
        
        let translatedContent = null; // Cache for translated English content
        
        translateBtn.addEventListener('click', function() {
            const currentLang = this.getAttribute('data-lang'); // 'vi' or 'en'
            const btnText = this.querySelector('span');
            const btnIcon = this.querySelector('i');
            
            if (currentLang === 'en') {
                // Restore original Vietnamese content instantly!
                if (articleTitle) articleTitle.innerText = originalContent.title;
                if (articleSapo) articleSapo.innerText = originalContent.sapo;
                if (contentText) contentText.innerHTML = originalContent.content;
                
                this.setAttribute('data-lang', 'vi');
                this.style.background = 'linear-gradient(135deg, #10b981 0%, #059669 100%)';
                if (btnText) btnText.innerText = 'Dịch sang Tiếng Anh';
                if (btnIcon) btnIcon.className = 'fas fa-language me-2';
                return;
            }
            
            // Switch to English translation
            if (translatedContent) {
                if (articleTitle) articleTitle.innerHTML = translatedContent.title;
                if (articleSapo) articleSapo.innerHTML = translatedContent.sapo;
                if (contentText) contentText.innerHTML = translatedContent.content;
                
                this.setAttribute('data-lang', 'en');
                this.style.background = 'linear-gradient(135deg, #4b5563 0%, #1f2937 100%)'; // Gray toggle color
                if (btnText) btnText.innerText = 'Xem Tiếng Việt';
                if (btnIcon) btnIcon.className = 'fas fa-undo me-2';
                return;
            }
            
            // Perform AJAX call to translate
            translateBtn.disabled = true;
            if (btnText) btnText.innerText = 'Đang dịch thuật...';
            
            // Wrap contents inside custom tags to easily split them back
            const combinedHtml = `
                <div id="t-title">${originalContent.title}</div>
                <div id="t-sapo">${originalContent.sapo}</div>
                <div id="t-body">${originalContent.content}</div>
            `;
            
            fetch('{{ route("ai.translate") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    content: combinedHtml,
                    target_lang: 'en'
                })
            })
            .then(response => response.json())
            .then(data => {
                translateBtn.disabled = false;
                if (data.translated) {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(data.translated, 'text/html');
                    
                    translatedContent = {
                        title: doc.getElementById('t-title') ? doc.getElementById('t-title').innerHTML : 'Translated Title',
                        sapo: doc.getElementById('t-sapo') ? doc.getElementById('t-sapo').innerHTML : 'Translated Sapo',
                        content: doc.getElementById('t-body') ? doc.getElementById('t-body').innerHTML : 'Translated Content'
                    };
                    
                    // Replace elements with translated English HTML
                    if (articleTitle) articleTitle.innerHTML = translatedContent.title;
                    if (articleSapo) articleSapo.innerHTML = translatedContent.sapo;
                    if (contentText) contentText.innerHTML = translatedContent.content;
                    
                    this.setAttribute('data-lang', 'en');
                    this.style.background = 'linear-gradient(135deg, #4b5563 0%, #1f2937 100%)';
                    if (btnText) btnText.innerText = 'Xem Tiếng Việt';
                    if (btnIcon) btnIcon.className = 'fas fa-undo me-2';
                } else {
                    alert('Lỗi dịch bài báo: ' + (data.error || 'AI phản hồi trống.'));
                    if (btnText) btnText.innerText = 'Dịch sang Tiếng Anh';
                }
            })
            .catch(err => {
                console.error(err);
                alert('Lỗi kết nối khi dịch thuật.');
                translateBtn.disabled = false;
                if (btnText) btnText.innerText = 'Dịch sang Tiếng Anh';
            });
        });
    }
</script>
@endsection
