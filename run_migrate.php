<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    Artisan::call('migrate', ['--force' => true]);
    echo Artisan::output();
    
    // Cập nhật các bài viết cũ thành 'published' để không bị ẩn
    App\Models\Post::whereNull('status')->orWhere('status', '')->update(['status' => 'published']);
    echo "Updated existing posts to published.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
