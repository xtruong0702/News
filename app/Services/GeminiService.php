<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected $apiKey;
    protected $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-3.1-flash-lite-preview:generateContent';

    public function __construct()
    {
        $this->apiKey = config('services.gemini.key');
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

    public function suggestContent($title)
    {
        $prompt = "Hãy đóng vai một biên tập viên tin tức. Dựa trên tiêu đề '{$title}', hãy viết một nội dung bài báo chi tiết, chuyên nghiệp, có đầy đủ các ý chính. Lưu ý QUAN TRỌNG: Chỉ trả về mã HTML sạch, không bao gồm các ký tự đánh dấu markdown như ```html hay ``` ở đầu và cuối. Chỉ sử dụng các thẻ p, h3, strong, ul, li.";
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
}
