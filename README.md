# 📰 News 24H - AI-Powered News & CMS Platform

[![Laravel Version](https://img.shields.io/badge/Laravel-v13.0-FF2D20?logo=laravel&logoColor=white)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/PHP-v8.3-777BB4?logo=php&logoColor=white)](https://php.net)
[![Database](https://img.shields.io/badge/Database-SQLite-003B57?logo=sqlite&logoColor=white)](https://sqlite.org)
[![Vite](https://img.shields.io/badge/Vite-v6.0-646CFF?logo=vite&logoColor=white)](https://vitejs.dev)
[![AI Integration](https://img.shields.io/badge/AI-Gemini%203.5%20Flash-4285F4?logo=googlegemini&logoColor=white)](https://deepmind.google)

**News 24H** là một nền tảng quản trị và đọc tin tức hiện đại, được xây dựng trên framework **Laravel 13** và tích hợp sâu các tính năng trí tuệ nhân tạo đột phá sử dụng **Google Gemini AI** và dịch vụ chuyển đổi văn bản thành giọng nói của **FPT AI**. Hệ thống được thiết kế với giao diện người dùng tinh tế (Glassmorphism, Responsive), cung cấp trải nghiệm đọc tin tối ưu và bộ công cụ hỗ trợ viết bài đắc lực cho biên tập viên.

---

## 🚀 Các tính năng nổi bật

### 🤖 1. Tính năng AI Đột phá (AI-Powered)
*   **Trợ lý Tin tức AI (Chatbot Độc giả):** Trợ lý ảo được gắn cố định (floating chat widget) ở góc màn hình. Chatbot sử dụng mô hình **Gemini 3.5 Flash** và tự động lấy thông tin từ **15 bài viết mới nhất** làm ngữ cảnh để trả lời người đọc, đồng thời tự động chèn liên kết tĩnh (slug link) đến bài viết liên quan.
*   **Tự động Gợi ý & Viết nội dung (Suggest Content):** Chỉ với một dòng mô tả ngắn từ admin/editor, AI sẽ tự động lập dàn ý và tạo ra một bài viết chi tiết, hoàn chỉnh với định dạng thẻ HTML sạch (p, h3, strong, ul, li).
*   **Viết lại & Tối ưu hóa bài viết (AI Rewrite):** Hỗ trợ kiểm tra lỗi chính tả, cải thiện câu từ, cấu trúc lại bài viết một cách mạch lạc, logic nhưng vẫn giữ nguyên 100% ý nghĩa cốt lõi.
*   **Tóm tắt bài báo (AI Summarize):** Chỉ với một nút bấm trên trang chi tiết, hệ thống tự động tóm tắt nội dung bài viết thành đoạn ngắn 2-3 câu súc tích giúp người đọc nắm bắt thông tin nhanh chóng.
*   **Dịch thuật thông minh bảo toàn định dạng HTML:** Hỗ trợ dịch bài báo đa ngôn ngữ (Tiếng Anh ⇆ Tiếng Việt) mà không làm phá hỏng các thẻ định dạng HTML trong bài viết.
*   **Đọc báo tự động (Text-to-Speech - TTS):** Tích hợp **FPT AI TTS**, tự động nhận diện ngôn ngữ bài báo và sử dụng giọng đọc tự nhiên (giọng nam *Minh Quang* cho Tiếng Việt và giọng nam *Lê Minh* cho Tiếng Anh) để đọc bài viết cho độc giả nghe.

### 📝 2. Hệ thống Quản trị Nội dung (CMS)
*   **Phân quyền người dùng chặt chẽ (RBAC):**
    *   `Admin` (Tổng biên tập): Toàn quyền quản lý bài viết, chuyên mục, bình luận, phân quyền người dùng và duyệt bài viết.
    *   `Writer` (Biên tập viên): Viết bài, cập nhật và quản lý các bài viết của chính mình (chờ Admin phê duyệt để xuất bản).
    *   `User` (Độc giả): Đăng ký tài khoản, đọc tin tức, gửi bình luận và trò chuyện với Trợ lý AI.
*   **Quản lý Bài viết & Chuyên mục:** Quy trình tạo mới bài viết trực quan, quản lý bài viết theo các trạng thái (Draft, Pending, Published).
*   **Bình luận & Tương tác:** Hệ thống bình luận thời gian thực dưới mỗi bài viết dành cho thành viên đã đăng nhập.
*   **Thống kê & Bộ lọc:** Tự động tăng lượt xem bài viết, lọc tin tức theo chuyên mục, bài viết xem nhiều nhất (Trending) và thanh công cụ tìm kiếm tin tức tối ưu.

---

## 🛠️ Công nghệ Sử dụng

*   **Backend:** PHP 8.3+, Laravel 13.x (sử dụng các tính năng mới nhất).
*   **Database:** SQLite (tiện lợi, nhanh chóng, không yêu cầu cài đặt MySQL/PostgreSQL).
*   **Frontend:** Blade Template, Vanilla CSS (Thiết kế hiện đại, hỗ trợ Responsive đầy đủ trên Mobile & Desktop), Vanilla JS.
*   **Asset Bundler:** Vite.
*   **AI Integrations:** Google Gemini API, FPT AI Text-to-Speech API.

---

## 💻 Hướng dẫn Cài đặt & Khởi chạy

Thực hiện theo các bước dưới đây để cài đặt dự án trên môi trường Local:

### 1. Yêu cầu hệ thống
*   PHP $\ge$ 8.3
*   Composer
*   Node.js & NPM

### 2. Các bước cài đặt

**Bước 1: Clone mã nguồn từ GitHub**
```bash
git clone https://github.com/username/news.git
cd news
```

**Bước 2: Cài đặt các gói phụ thuộc (Dependencies)**
```bash
# Cài đặt các thư viện PHP qua Composer
composer install

# Cài đặt các thư viện JS qua NPM
npm install
```

**Bước 3: Thiết lập File cấu hình môi trường**
Sao chép file cấu hình mẫu `.env.example` thành `.env`:
```bash
cp .env.example .env
```
Sau đó, tạo khóa ứng dụng (Application Key):
```bash
php artisan key:generate
```

**Bước 4: Cấu hình các API Key dịch vụ AI**
Mở file `.env` vừa tạo và điền các khóa API thích hợp:
```env
# Cấu hình API Google Gemini
GEMINI_API_KEY=your_gemini_api_key_here
GEMINI_MODEL=gemini-3.5-flash
GEMINI_API_VERSION=v1

# Cấu hình API FPT AI Text-to-Speech
FPT_AI_KEY=your_fpt_ai_api_key_here
```

**Bước 5: Tạo cơ sở dữ liệu và Migrations**
Khởi tạo file SQLite và chạy migrations bằng cách thực hiện:
```bash
# Tạo file database SQLite trống (nếu chưa có)
touch database/database.sqlite

# Chạy migrations để tạo bảng
php artisan migrate --force
# Hoặc sử dụng file script hỗ trợ có sẵn:
php run_migrate.php
```

**Bước 6: Seed dữ liệu mẫu (Dummy data & Tài khoản mặc định)**
Dự án cung cấp sẵn Seed để bạn tạo tài khoản quản trị và một số bài viết mẫu:
```bash
# Seed tài khoản Admin & Editor mẫu
php artisan db:seed --class=AdminUserSeeder

# Seed một số bài viết chất lượng cao ban đầu
php artisan db:seed --class=NewArticlesSeeder

# (Tùy chọn) Sinh ngẫu nhiên 50 bài báo ảo để test giao diện và phân trang
php generate_posts.php
```

**Bước 7: Biên dịch Assets & Chạy máy chủ**
Dự án đã cấu hình sẵn lệnh gộp tiện lợi để khởi động toàn bộ dịch vụ (Web server, Queue worker, Vite dev server) thông qua một lệnh duy nhất:
```bash
composer run dev
```
Hoặc chạy thủ công từng dịch vụ:
```bash
# Biên dịch và lắng nghe thay đổi của CSS/JS
npm run dev

# Khởi chạy máy chủ Laravel
php artisan serve
```

Ứng dụng của bạn sẽ hoạt động tại địa chỉ: **`http://127.0.0.1:8000`**

---

## 🔑 Tài khoản Thử nghiệm mặc định

Sau khi chạy seed `AdminUserSeeder`, bạn có thể đăng nhập bằng các tài khoản sau để trải nghiệm các quyền hạn khác nhau:

| Quyền hạn | Email | Mật khẩu |
| :--- | :--- | :--- |
| **Admin (Tổng biên tập)** | `admin@gmail.com` | `admin123` |
| **Writer (Biên tập viên)** | `editor@gmail.com` | `12345678` |

---

## 📂 Cấu trúc thư mục chính của dự án

Các phần logic xử lý cốt lõi nằm ở các file sau:
*   `app/Http/Controllers/AIController.php`: Điều hướng xử lý các API liên quan đến AI (Tóm tắt, Dịch thuật, Trò chuyện với Chatbot, TTS).
*   `app/Services/GeminiService.php`: Tương tác trực tiếp với API Google Gemini để sinh, dịch, viết lại và trả lời câu hỏi của độc giả.
*   `app/Services/TTSService.php`: Xử lý gọi API FPT AI để sinh giọng nói từ văn bản bài viết.
*   `routes/web.php`: Khai báo toàn bộ định tuyến bao gồm các API AI, trang độc giả công khai và Admin Panel.
*   `resources/views/article.blade.php`: Giao diện chi tiết bài viết (chứa trình đọc tiếng nói TTS, AI tóm tắt/dịch thuật, và bình luận).
*   `resources/views/layouts/master.blade.php`: Giao diện khung của toàn website (tích hợp khung Chatbot Trợ lý AI ở góc màn hình).

---

## 📄 Giấy phép (License)
Dự án này được phát triển dưới giấy phép **MIT**. Xem chi tiết tại file [LICENSE](LICENSE).
