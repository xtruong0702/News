<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    protected $fillable = ['user_id', 'post_id', 'content'];

    /**
     * Một bình luận thuộc về một người dùng.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Một bình luận thuộc về một bài viết.
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
