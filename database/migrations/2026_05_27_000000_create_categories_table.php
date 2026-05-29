<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // Pre-populate with default categories to avoid breaking current layout
        $categories = [
            ['name' => 'Thời trang', 'slug' => 'thoi-trang'],
            ['name' => 'Làm đẹp', 'slug' => 'lam-dep'],
            ['name' => 'Sống khỏe', 'slug' => 'song-khoe'],
            ['name' => 'Công nghệ', 'slug' => 'cong-nghe'],
            ['name' => 'Thế giới', 'slug' => 'the-gioi'],
            ['name' => 'Kinh doanh', 'slug' => 'kinh-doanh'],
        ];

        foreach ($categories as $cat) {
            DB::table('categories')->insert(array_merge($cat, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
