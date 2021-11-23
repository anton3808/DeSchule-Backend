<?php

namespace Modules\Study\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Orchid\Screen\AsSource;

class Lesson extends Model
{
    use Translatable, AsSource;

    protected $fillable = ['order', 'level_id'];

    public $translatedAttributes = ['title'];

    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class, 'level_id', 'id');
    }

    /**
     * The attributes for which you can use filters in url.
     *
     * @var array
     */
    protected $allowedFilters = [
        'id',
        'order',
        'level_id',
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
        'order',
        'updated_at',
        'created_at',
    ];

    public function elements(): BelongsToMany
    {
        return $this->belongsToMany(LessonElement::class, 'lessons_has_lesson_elements', 'lesson_id', 'lesson_element_id');
    }
}

class LessonTranslation extends Model
{
    public $timestamps = false;
}
