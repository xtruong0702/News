<?php

namespace App\Http\Controllers;

use App\Services\GeminiService;
use Illuminate\Http\Request;

class AIController extends Controller
{
    protected $gemini;

    public function __construct(GeminiService $gemini)
    {
        $this->gemini = $gemini;
    }

    /**
     * API Tóm tắt nội dung
     */
    public function summarize(Request $request)
    {
        $content = $request->input('content');
        if (!$content) return response()->json(['error' => 'Nội dung trống'], 400);

        $summary = $this->gemini->summarize($content);
        return response()->json(['summary' => $summary]);
    }

    /**
     * API Gợi ý nội dung cho Admin
     */
    public function suggest(Request $request)
    {
        $description = $request->input('description');
        if (!$description) return response()->json(['error' => 'Mô tả ngắn trống'], 400);

        $suggestion = $this->gemini->suggestContent($description);
        return response()->json(['suggestion' => $suggestion]);
    }

    /**
     * API Viết lại và sắp xếp nội dung
     */
    public function rewrite(Request $request)
    {
        $content = $request->input('content');
        if (!$content) return response()->json(['error' => 'Nội dung trống'], 400);

        $rewritten = $this->gemini->rewriteContent($content);
        return response()->json(['rewritten' => $rewritten]);
    }

    /**
     * API Chuyển văn bản thành giọng nói (FPT AI TTS)
     */
    public function tts(Request $request, \App\Services\TTSService $ttsService)
    {
        $text = $request->input('text');
        
        if (!$text) return response()->json(['error' => 'Nội dung trống'], 400);

        // Làm sạch văn bản: xóa tag HTML để FPT xử lý nhanh hơn
        $cleanText = trim(strip_tags($text));

        // Nhận diện ngôn ngữ đơn giản
        $englishWords = [' the ', ' and ', ' is ', ' are ', ' in ', ' of ', ' to '];
        $isEnglish = collect($englishWords)->contains(fn($word) => str_contains(strtolower($cleanText), $word));
        
        $voice = $isEnglish ? 'leminh' : 'minhquang'; // Lê Minh cho tiếng Anh, Minh Quang cho tiếng Việt

        $result = $ttsService->synthesize($cleanText, $voice);
        
        if ($result && isset($result['async'])) {
            return response()->json($result);
        }

        return response()->json(['error' => 'Không thể tạo giọng nói từ FPT AI.'], 500);
    }

    /**
     * API Dịch bài báo đa ngôn ngữ bằng AI
     */
    public function translate(Request $request)
    {
        $content = $request->input('content');
        $targetLang = $request->input('target_lang', 'en');
        if (!$content) return response()->json(['error' => 'Nội dung trống'], 400);

        $translated = $this->gemini->translateContent($content, $targetLang);
        return response()->json(['translated' => $translated]);
    }

    /**
     * API Trợ lý Tin tức AI (Chatbot)
     */
    public function chat(Request $request)
    {
        $message = $request->input('message');
        if (!$message) return response()->json(['error' => 'Tin nhắn trống'], 400);

        // Lấy 15 bài báo xuất bản mới nhất để làm ngữ cảnh
        $posts = \App\Models\Post::where('status', 'published')
            ->latest()
            ->take(15)
            ->get(['title', 'slug', 'category', 'description']);

        $postsContext = "";
        foreach ($posts as $key => $post) {
            $postsContext .= ($key + 1) . ". Tiêu đề: \"{$post->title}\" | Chuyên mục: \"{$post->category}\" | Đường dẫn tĩnh (slug): \"{$post->slug}\" | Mô tả ngắn: \"{$post->description}\"\n";
        }

        $response = $this->gemini->chatWithAssistant($message, $postsContext);
        return response()->json(['response' => $response]);
    }
}
