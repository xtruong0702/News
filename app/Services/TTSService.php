<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TTSService
{
    protected $apiKey;
    protected $baseUrl = 'https://api.fpt.ai/hmi/tts/v5';

    public function __construct()
    {
        $this->apiKey = trim(env('FPT_AI_KEY'));
    }

    public function synthesize($text, $voice = 'minhquang')
    {
        if (!$this->apiKey) return null;

        try {
            // Thử gửi với cả 2 loại header để chắc chắn
            $response = Http::withHeaders([
                'api-key' => $this->apiKey,
                'api_key' => $this->apiKey,
                'voice' => $voice,
                'speed' => '0',
            ])->withBody($text, 'text/plain')->post($this->baseUrl);

            if ($response->successful()) {
                $data = $response->json();
                Log::info('FPT AI Success: ', $data);
                return $data;
            }

            Log::error('FPT AI TTS Error: ' . $response->body());
            return null;
        } catch (\Exception $e) {
            Log::error('FPT TTS Exception: ' . $e->getMessage());
            return null;
        }
    }
}
