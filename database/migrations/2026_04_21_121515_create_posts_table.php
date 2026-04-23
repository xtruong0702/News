<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('posts', function (Blueprint $table) {
        $table->id();
        $table->string('title');        // Tiêu đề
        $table->string('slug')->unique(); // Đường dẫn không dấu (ví dụ: tin-tuc-ai)
        $table->text('description');     // Mô tả ngắn
        $table->longText('content');     // Nội dung chi tiết
        $table->string('image')->nullable(); // Hình ảnh bài viết
        $table->string('category');      // Chuyên mục
        $table->integer('views')->default(0); // Lượt xem
        $table->timestamps();            // created_at và updated_at
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
