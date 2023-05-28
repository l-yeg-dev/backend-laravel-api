<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'article_id',
        'description',
        'content',
        'url',
        'image_url',
        'source_id',
        'author_id',
        'category_id',
        'published_at'
    ];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function source()
    {
        return $this->belongsTo(Source::class);
    }

    public function category()
    {
        return $this->belongsTo(Source::class);
    }
}
