<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.key');

        $version = config('services.gemini.version', 'v1');
        $model = config('services.gemini.model', 'gemini-3.5-flash');

        // Normalize model name (strip any leading 'models/' if present)
        $model = preg_replace('#^models/#', '', $model);

        $this->baseUrl = "https://generativelanguage.googleapis.com/{$version}/models/{$model}:generateContent";
    }

    /**
     * Gửi yêu cầu đến Gemini AI
     */
    public function generate($prompt)
    {
        if (!$this->apiKey) {
            return "Vui lòng cấu hình GEMINI_API_KEY trong file .env";
        }

        try {
            $response = Http::post($this->baseUrl . '?key=' . $this->apiKey, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['candidates'][0]['content']['parts'][0]['text'] ?? "Không có phản hồi từ AI.";
            }

            Log::error('Gemini API Error Detail: ' . $response->body());
            return "Lỗi kết nối AI: " . $response->status() . " - " . ($response->json()['error']['message'] ?? 'Unknown Error');

        } catch (\Exception $e) {
            Log::error('Gemini Service Exception: ' . $e->getMessage());
            return "Đã xảy ra lỗi khi kết nối với AI.";
        }
    }

    /**
     * Tóm tắt nội dung bài viết
     */
    public function summarize($content)
    {
        $prompt = "Hãy đóng vai một biên tập viên tin tức chuyên nghiệp. Hãy tóm tắt nội dung sau đây thành một đoạn ngắn khoảng 2-3 câu, súc tích và hấp dẫn người đọc. Nội dung: " . $content;
        return $this->generate($prompt);
    }

    public function suggestContent($description)
    {
        $prompt = "Hãy đóng vai một biên tập viên tin tức chuyên nghiệp. Dựa trên mô tả ngắn sau đây: '{$description}', hãy viết một nội dung bài báo chi tiết, đầy đủ các ý chính, có bố cục rõ ràng và hấp dẫn người đọc. Lưu ý QUAN TRỌNG: Chỉ trả về mã HTML sạch, không bao gồm các ký tự đánh dấu markdown như ```html hay ``` ở đầu và cuối. Chỉ sử dụng các thẻ p, h3, strong, ul, li.";
        return $this->generate($prompt);
    }

    /**
     * Sửa lại nội dung và sắp xếp lại hợp lý
     */
    public function rewriteContent($content)
    {
        $prompt = "Hãy đóng vai một tổng biên tập tin tức chuyên nghiệp. Nhiệm vụ của bạn là SỬA LỖI, VIẾT LẠI cho hay hơn và SẮP XẾP LẠI bố cục của bài viết sau đây một cách logic, mạch lạc và hấp dẫn nhất. 
        Lưu ý QUAN TRỌNG: 
        1. Phải giữ lại toàn bộ ý chính của bài gốc.
        2. Sắp xếp lại các đoạn văn cho hợp lý, thêm tiêu đề phụ (h3) nếu cần để bài viết rõ ràng.
        3. Chỉ trả về mã HTML sạch, không bao gồm các ký tự đánh dấu markdown như ```html hay ``` ở đầu và cuối. 
        4. Chỉ sử dụng các thẻ p, h3, strong, ul, li.
        
        Nội dung gốc: " . $content;
        
        return $this->generate($prompt);
    }

    /**
     * Dịch nội dung bài báo sang ngôn ngữ mục tiêu (Tiếng Anh hoặc Tiếng Việt) bảo toàn HTML
     */
    public function translateContent($content, $targetLang)
    {
        $langName = ($targetLang === 'en') ? 'Anh (English)' : 'Việt (Vietnamese)';
        $prompt = "Hãy đóng vai một biên dịch viên tin tức chuyên nghiệp. Nhiệm vụ của bạn là dịch nội dung sau đây sang tiếng {$langName}.
        Lưu ý CỰC KỲ QUAN TRỌNG:
        1. Phải giữ nguyên 100% tất cả các cấu trúc thẻ HTML (như p, h3, strong, ul, li, div...) ở đúng vị trí cũ.
        2. Dịch thật tự nhiên, lưu loát, chuẩn văn phong báo chí chính thống.
        3. Chỉ trả về mã HTML sạch sau khi dịch, TUYỆT ĐỐI không bao gồm các ký tự đánh dấu markdown như ```html hay ``` ở đầu và cuối bài.
        
        Nội dung cần dịch: " . $content;
        
        return $this->generate($prompt);
    }

    /**
     * Trợ lý Chatbot trả lời tin tức dựa trên danh sách bài viết hiện tại
     */
    public function chatWithAssistant($message, $postsContext)
    {
        $prompt = "Bạn là trợ lý ảo thông minh tên là 'Trợ lý Tin tức AI 🤖' của trang báo điện tử 'NEWS 24H' (phát triển bởi Google DeepMind).
        Nhiệm vụ của bạn là giải đáp thân thiện, ngắn gọn và hữu ích cho độc giả bằng tiếng Việt.
        Dưới đây là danh sách 15 bài báo mới nhất đang được đăng tải trên website của chúng ta:
        
        {$postsContext}
        
        Hãy sử dụng danh sách trên để trả lời thắc mắc của độc giả.
        Lưu ý CỰC KỲ QUAN TRỌNG:
        1. Nếu độc giả hỏi về tin tức mới hôm nay, tin nổi bật hoặc tìm bài viết liên quan, hãy gợi ý cho họ các bài báo trong danh sách trên.
        2. Khi gợi ý một bài viết, hãy chèn link liên kết tĩnh dạng: [Tên bài viết](http://localhost:8000/article/slug-cua-bai-viet) (ví dụ: [Vũ trụ AI](http://localhost:8000/article/vu-tru-ai)). Link này KHÔNG ĐƯỢC thêm dấu tiếng Việt hay khoảng trắng ở phần slug.
        3. Hãy trả lời ngắn gọn (khoảng 3-4 câu), súc tích, vui vẻ và lịch sự. Nếu họ hỏi về các chủ đề không liên quan đến tin tức hoặc ngoài lề, hãy trả lời ngắn gọn và khéo léo đưa họ quay lại với tin tức của website.
        
        Tin nhắn của độc giả: \"{$message}\"";
        
        return $this->generate($prompt);
    }
}
