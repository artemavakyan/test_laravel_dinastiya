<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Screen\AsSource;

class Comment extends Model
{
    use AsSource;

    protected $fillable = ['article_id', 'name', 'content', 'rating'];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}
