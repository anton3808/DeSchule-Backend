<?php

namespace App\Models\News;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class NewsComment extends Model
{
    use AsSource;

    protected $table = 'news_comment';

    protected $fillable = ['news_id', 'user_id', 'news_comment_id', 'content', 'status'];

    public $translatedAttributes = ['title', 'description'];

    /**
     * The attributes for which you can use filters in url.
     *
     * @var array
     */
    protected $allowedFilters = [
        'id',
        'status',
        'updated_at',
        'created_at',
    ];

    /**
     * The attributes for which can use sort in url.
     *
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'status',
        'updated_at',
        'created_at',
    ];

    public function news()
    {
        return $this->belongsTo(News::class);
    }

    public function child()
    {
        return $this->hasMany(NewsComment::class, 'news_comment_id');
    }

    //recursive child call
    public function replies()
    {
        return $this->child()->with('replies')
            ->where('status', 'active')
            ->orderBy('id');
    }
}
