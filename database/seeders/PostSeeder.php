<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;           // <--- THÊM DÒNG NÀY
use Illuminate\Support\Str;    // <--- ĐẢM BẢO CÓ DÒNG NÀY

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $title = "Bài viết tin tức số " . $i;
            Post::create([
                'title' => $title,
                'slug' => Str::slug($title),
                'description' => "Đây là mô tả ngắn cho bài viết thứ " . $i,
                'content' => "Đây là nội dung chi tiết cực kỳ dài của bài viết...",
                'image' => "https://picsum.photos/id/".($i+20)."/800/450",
                'category' => "Công nghệ",
            ]);
        }
    }
}