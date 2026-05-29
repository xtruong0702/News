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
    
    {{-- Chống nhấp nháy nền trắng khi bật Dark Mode (Immediate head theme script) --}}
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark-mode');
            }
        })();
    </script>

    <style>
        :root {
            --primary-color: #6366f1; /* Indigo */
            --accent-color: #a855f7;  /* Purple */
            --bg-light: #f8fafc;
            --text-main: #334155;
            --text-heading: #0f172a;
            --card-bg: #ffffff;
            --border-color: rgba(0,0,0,0.05);
            --input-bg: #ffffff;
            --input-text: #334155;
            --header-bg: rgba(255, 255, 255, 0.85);
            --dropdown-bg: #ffffff;
        }

        html.dark-mode {
            --bg-light: #0b0f19;       /* Deep rich modern dark navy */
            --text-main: #cbd5e1;      /* Bright, highly legible silver Slate-300 */
            --text-heading: #ffffff;   /* Pure white to make text pop out! */
            --card-bg: #151f32;        /* Sleek card background */
            --border-color: rgba(255,255,255,0.08);
            --input-bg: #1e293b;
            --input-text: #f1f5f9;
            --header-bg: rgba(21, 31, 50, 0.85);
            --dropdown-bg: #151f32;
        }

        body {
            font-family: 'Outfit', sans-serif;
            color: var(--text-main);
            background-color: var(--bg-light);
            line-height: 1.6;
            transition: background-color 0.4s ease, color 0.4s ease, border-color 0.4s ease;
        }

        h1, h2, h3, .navbar-brand, .heading-font {
            font-family: 'Playfair Display', serif;
            color: var(--text-heading);
            font-weight: 700;
            transition: color 0.4s ease;
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
            background: var(--card-bg);
        }
        .card-news:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(99, 102, 241, 0.1);
        }

        .sticky-header {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: var(--header-bg);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
            transition: all 0.4s ease;
        }

        /* Utility classes để cắt chữ (Chống tràn chữ) */
        .line-clamp-1 { display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; }
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
        
        .transition-hover { transition: all 0.3s ease; }
        .hover-text-primary:hover { color: var(--primary-color) !important; }

        /* --- GLOBAL DARK MODE OVERRIDES --- */
        html.dark-mode .bg-white {
            background-color: var(--card-bg) !important;
            color: var(--text-main) !important;
        }
        html.dark-mode .text-dark,
        html.dark-mode .article-title,
        html.dark-mode h1, html.dark-mode h2, html.dark-mode h3, 
        html.dark-mode h4, html.dark-mode h5, html.dark-mode h6,
        html.dark-mode .heading-font {
            color: var(--text-heading) !important;
        }
        html.dark-mode .text-muted {
            color: var(--text-main) !important;
        }
        html.dark-mode .card, 
        html.dark-mode .dropdown-menu,
        html.dark-mode .list-group-item,
        html.dark-mode .main-article,
        html.dark-mode .author-card,
        html.dark-mode .comment-bubble,
        html.dark-mode .related-post-card {
            background-color: var(--card-bg) !important;
            background: var(--card-bg) !important;
            border-color: var(--border-color) !important;
            color: var(--text-main) !important;
        }
        html.dark-mode .breaking-news-container {
            background-color: var(--card-bg) !important;
            background: var(--card-bg) !important;
            border: 1px solid var(--border-color) !important;
        }
        html.dark-mode .dropdown-item {
            color: var(--text-main) !important;
            transition: background-color 0.2s ease;
        }
        html.dark-mode .dropdown-item:hover {
            background-color: rgba(255, 255, 255, 0.05) !important;
            color: var(--text-heading) !important;
        }
        html.dark-mode input, 
        html.dark-mode textarea, 
        html.dark-mode select {
            background-color: var(--input-bg) !important;
            color: var(--input-text) !important;
            border-color: var(--border-color) !important;
        }
        html.dark-mode input::placeholder,
        html.dark-mode textarea::placeholder {
            color: rgba(255, 255, 255, 0.3) !important;
        }
        html.dark-mode .bg-light {
            background-color: #1e293b !important;
        }
        html.dark-mode .border,
        html.dark-mode .border-bottom,
        html.dark-mode .border-light,
        html.dark-mode .border-top,
        html.dark-mode .border-start,
        html.dark-mode .border-end {
            border-color: var(--border-color) !important;
            border-bottom-color: var(--border-color) !important;
            border-top-color: var(--border-color) !important;
            border-left-color: var(--border-color) !important;
            border-right-color: var(--border-color) !important;
        }
        html.dark-mode .nav-link {
            color: var(--text-main) !important;
        }
        html.dark-mode .nav-link:hover, 
        html.dark-mode .nav-link.active {
            color: var(--primary-color) !important;
        }
        html.dark-mode footer,
        html.dark-mode .bg-dark {
            background-color: #05080f !important;
            border-top: 1px solid var(--border-color);
        }
        html.dark-mode .modal-content {
            background-color: var(--card-bg) !important;
            border-color: var(--border-color) !important;
            color: var(--text-main) !important;
        }
        html.dark-mode .lead,
        html.dark-mode .lead.fw-bold {
            color: var(--text-heading) !important;
            background-color: #1e293b !important;
            border-left-color: var(--primary-color) !important;
        }
        html.dark-mode .content-text,
        html.dark-mode .content-text *,
        html.dark-mode .article-body,
        html.dark-mode .article-body * {
            color: var(--text-main) !important;
        }
        html.dark-mode .comment-bubble:hover {
            background-color: #1e293b !important;
        }

        /* --- AI CHATBOT FLOAT WIDGET --- */
        #ai-chatbot-bubble {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
            box-shadow: 0 10px 25px rgba(99, 102, 241, 0.4);
            z-index: 9999;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        #ai-chatbot-bubble:hover {
            transform: scale(1.1) translateY(-3px);
            box-shadow: 0 15px 30px rgba(99, 102, 241, 0.5);
        }
        #ai-chatbot-bubble i {
            color: white;
            font-size: 1.8rem;
        }
        
        #ai-chatbot-window {
            position: fixed;
            bottom: 100px;
            right: 30px;
            width: 380px;
            height: 500px;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.15);
            z-index: 9999;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transform: scale(0.9) translateY(20px);
            opacity: 0;
            pointer-events: none;
        }
        #ai-chatbot-window.show {
            transform: scale(1) translateY(0);
            opacity: 1;
            pointer-events: auto;
        }
        .chat-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
            color: white;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .chat-messages {
            flex-grow: 1;
            padding: 20px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 15px;
            background: var(--bg-light);
        }
        .chat-bubble {
            max-width: 80%;
            padding: 12px 16px;
            border-radius: 18px;
            font-size: 0.92rem;
            line-height: 1.5;
            animation: fadeInChat 0.3s ease forwards;
        }
        .chat-bubble.bot {
            background: var(--card-bg);
            color: var(--text-main);
            align-self: flex-start;
            border-bottom-left-radius: 4px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.03);
            border: 1px solid var(--border-color);
        }
        .chat-bubble.user {
            background: var(--primary-color);
            color: white;
            align-self: flex-end;
            border-bottom-right-radius: 4px;
            box-shadow: 0 4px 10px rgba(99, 102, 241, 0.1);
        }
        .chat-input-area {
            padding: 15px 20px;
            background: var(--card-bg);
            border-top: 1px solid var(--border-color);
            display: flex;
            gap: 10px;
            align-items: center;
        }
        .chat-input-area input {
            flex-grow: 1;
            border: none;
            background: var(--bg-light);
            padding: 10px 18px;
            border-radius: 30px;
            font-size: 0.95rem;
            color: var(--text-main);
            outline: none;
            border: 1px solid var(--border-color);
            transition: border-color 0.2s ease;
        }
        .chat-input-area input:focus {
            border-color: var(--primary-color);
        }
        @keyframes fadeInChat {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    @include('partials.header')

    <main class="container py-4">
        @yield('content')
    </main>

    @include('partials.footer')

    {{-- AI Chatbot UI --}}
    <div id="ai-chatbot-bubble" title="Hỏi Trợ lý Tin tức AI">
        <i class="bi bi-robot"></i>
    </div>

    <div id="ai-chatbot-window">
        <div class="chat-header">
            <div class="d-flex align-items-center">
                <div class="bg-white bg-opacity-25 rounded-circle p-1 me-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    <i class="bi bi-robot text-white fs-5"></i>
                </div>
                <div>
                    <h6 class="mb-0 fw-bold">Trợ lý Tin tức AI</h6>
                    <small class="x-small text-white-50 d-flex align-items-center gap-1" style="font-size: 0.7rem;">
                        <span class="d-inline-block rounded-circle bg-success" style="width: 8px; height: 8px;"></span> Đang hoạt động
                    </small>
                </div>
            </div>
            <button type="button" id="chat-close-btn" class="btn-close btn-close-white shadow-none" style="font-size: 0.8rem;"></button>
        </div>
        
        <div class="chat-messages" id="chat-messages-container">
            <div class="chat-bubble bot shadow-sm">
                Xin chào! Tôi là **Trợ lý Tin tức AI 🤖** của NEWS 24H. Bạn muốn tìm hiểu hoặc tìm kiếm tin tức gì hôm nay? 
                <br><br>
                Gợi ý câu hỏi:
                <ul class="mb-0 ps-3 mt-1 text-primary" style="font-size: 0.85rem; cursor: pointer;">
                    <li class="chat-suggest-item mb-1">Hôm nay có gì mới?</li>
                    <li class="chat-suggest-item mb-1">Có tin tức nào về Công nghệ không?</li>
                    <li class="chat-suggest-item">Thời trang & Làm đẹp hôm nay có gì hot?</li>
                </ul>
            </div>
        </div>
        
        <div class="chat-input-area">
            <input type="text" id="chat-user-input" placeholder="Nhập câu hỏi của bạn..." autocomplete="off">
            <button type="button" id="chat-send-btn" class="btn btn-primary rounded-circle p-0 d-flex align-items-center justify-content-center shadow" style="width: 38px; height: 38px;">
                <i class="bi bi-send-fill text-white fs-6"></i>
            </button>
        </div>
    </div>

    {{-- AI Chatbot JS Logic --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bubble = document.getElementById('ai-chatbot-bubble');
            const windowEl = document.getElementById('ai-chatbot-window');
            const closeBtn = document.getElementById('chat-close-btn');
            const sendBtn = document.getElementById('chat-send-btn');
            const inputEl = document.getElementById('chat-user-input');
            const messagesContainer = document.getElementById('chat-messages-container');

            if (!bubble || !windowEl) return;

            // 1. Detect login status changes to automatically clear history
            const currentUserId = "{{ Auth::check() ? Auth::id() : 'guest' }}";
            const savedUserId = localStorage.getItem('news_chat_user_id');
            if (savedUserId && savedUserId !== currentUserId) {
                localStorage.removeItem('news_chat_history');
                localStorage.removeItem('news_chat_window_open');
            }
            localStorage.setItem('news_chat_user_id', currentUserId);

            // 2. Restore Chat History from LocalStorage (keeps state across page loads)
            const savedHistory = localStorage.getItem('news_chat_history');
            if (savedHistory) {
                messagesContainer.innerHTML = savedHistory;
                setTimeout(() => {
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                }, 50);
            }

            // 3. Restore Chat Window Open/Close state
            const isWindowOpen = localStorage.getItem('news_chat_window_open');
            if (isWindowOpen === 'true') {
                windowEl.classList.add('show');
                setTimeout(() => {
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                }, 50);
            }

            // Save history helper function
            function saveChatHistory() {
                localStorage.setItem('news_chat_history', messagesContainer.innerHTML);
            }

            // Toggle chat window open/close
            bubble.addEventListener('click', function() {
                windowEl.classList.toggle('show');
                if (windowEl.classList.contains('show')) {
                    localStorage.setItem('news_chat_window_open', 'true');
                    setTimeout(() => inputEl.focus(), 300);
                } else {
                    localStorage.setItem('news_chat_window_open', 'false');
                }
            });

            closeBtn.addEventListener('click', function() {
                windowEl.classList.remove('show');
                localStorage.setItem('news_chat_window_open', 'false');
            });

            // Handle suggestions clicks
            messagesContainer.addEventListener('click', function(e) {
                if (e.target.classList.contains('chat-suggest-item')) {
                    inputEl.value = e.target.innerText;
                    sendMessage();
                }
            });

            // Handle Enter keypress
            inputEl.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    sendMessage();
                }
            });

            sendBtn.addEventListener('click', sendMessage);

            function sendMessage() {
                const message = inputEl.value.trim();
                if (!message) return;

                // 1. Render User message
                appendMessage(message, 'user');
                inputEl.value = '';

                // 2. Render Bot Typing loading bubble
                const typingBubbleId = appendTypingBubble();

                // 3. Make API request to /ai/chat
                fetch('/ai/chat', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ message: message })
                })
                .then(response => response.json())
                .then(data => {
                    removeTypingBubble(typingBubbleId);
                    if (data.response) {
                        appendMessage(data.response, 'bot');
                    } else {
                        appendMessage('Xin lỗi, tôi không thể xử lý yêu cầu lúc này. Vui lòng thử lại!', 'bot');
                    }
                })
                .catch(err => {
                    console.error(err);
                    removeTypingBubble(typingBubbleId);
                    appendMessage('Có lỗi kết nối xảy ra. Vui lòng kiểm tra mạng và thử lại sau.', 'bot');
                });
            }

            function appendMessage(text, sender) {
                const bubble = document.createElement('div');
                bubble.className = `chat-bubble ${sender} shadow-sm`;
                
                if (sender === 'bot') {
                    // Parse custom markdown tags safely
                    bubble.innerHTML = parseMarkdown(text);
                } else {
                    bubble.innerText = text;
                }
                
                messagesContainer.appendChild(bubble);
                messagesContainer.scrollTop = messagesContainer.scrollHeight;

                // Save to LocalStorage
                saveChatHistory();
            }

            function appendTypingBubble() {
                const id = 'typing-' + Date.now();
                const bubble = document.createElement('div');
                bubble.id = id;
                bubble.className = 'chat-bubble bot shadow-sm d-flex align-items-center gap-1';
                bubble.innerHTML = `
                    <span class="spinner-grow spinner-grow-sm text-primary" style="animation-duration: 0.75s; width: 8px; height: 8px;"></span>
                    <span class="spinner-grow spinner-grow-sm text-primary" style="animation-duration: 0.75s; animation-delay: 0.15s; width: 8px; height: 8px;"></span>
                    <span class="spinner-grow spinner-grow-sm text-primary" style="animation-duration: 0.75s; animation-delay: 0.3s; width: 8px; height: 8px;"></span>
                `;
                messagesContainer.appendChild(bubble);
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
                return id;
            }

            function removeTypingBubble(id) {
                const bubble = document.getElementById(id);
                if (bubble) bubble.remove();
            }

            function parseMarkdown(text) {
                // Convert < and > to prevent raw HTML injections
                let cleanText = text.replace(/</g, "&lt;").replace(/>/g, "&gt;");
                // Bold text **bold**
                cleanText = cleanText.replace(/\*\*(.*?)\*\*/g, "<strong>$1</strong>");
                // Markdown link [text](url)
                cleanText = cleanText.replace(/\[(.*?)\]\((.*?)\)/g, '<a href="$2" class="fw-bold text-primary text-decoration-none border-bottom border-primary transition-hover hover-text-primary" target="_blank">$1 <i class="bi bi-box-arrow-up-right small" style="font-size:0.65rem;"></i></a>');
                // Replace line breaks \n with <br>
                cleanText = cleanText.replace(/\n/g, "<br>");
                return cleanText;
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>