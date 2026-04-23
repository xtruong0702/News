<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // Thêm dòng này để cho phép lưu dữ liệu
    protected $fillable = [
        'title', 
        'slug', 
        'description', 
        'content', 
        'image', 
        'category'
    ];
    /**
     * Một bài viết có nhiều bình luận.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }
}