<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    // Thêm dòng này để cho phép lưu dữ liệu
    protected $fillable = [
        'title', 
        'slug', 
        'description', 
        'content', 
        'image', 
        'category',
        'user_id',
        'status'
    ];

    /**
     * Một bài viết thuộc về một người dùng (tác giả).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Một bài viết có nhiều bình luận.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }
}