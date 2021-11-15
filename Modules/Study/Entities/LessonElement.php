<?php

namespace Modules\Study\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Screen\AsSource;

class LessonElement extends Model
{
    use Translatable, AsSource;

    protected $fillable = ['icon', 'element_type_id', 'data'];

    public $translatedAttributes = ['title', 'description'];

    public function elementType(): BelongsTo
    {
        return $this->belongsTo(LessonElementType::class, 'element_type_id', 'id');
    }

    /**
     * The attributes for which you can use filters in url.
     *
     * @var array
     */
    protected $allowedFilters = [
        'id',
        'element_type_id',
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
        'updated_at',
        'created_at',
    ];
}

class LessonElementTranslation extends Model
{
    public $timestamps = false;
}
