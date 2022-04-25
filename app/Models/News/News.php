<?php

namespace App\Models\News;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Screen\AsSource;

class News extends Model
{
    use Translatable, AsSource;

    protected $fillable = ['image', 'status'];

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

    public function comments(): HasMany
    {
        return $this->hasMany(NewsComment::class, 'news_id', 'id')->where('news_comment_id', NULL);
    }
}
