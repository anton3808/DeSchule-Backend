<?php

namespace Modules\Study\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Screen\AsSource;

class Level extends Model
{
    use Translatable, AsSource;

    protected $fillable = ['priority', 'code'];

    public $translatedAttributes = ['title'];

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class, 'level_id', 'id');
    }

    /**
     * The attributes for which you can use filters in url.
     *
     * @var array
     */
    protected $allowedFilters = [
        'id',
        'priority',
        'code',
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
        'priority',
        'updated_at',
        'created_at',
    ];
}

class LevelTranslation extends Model
{
    public $timestamps = false;
}
