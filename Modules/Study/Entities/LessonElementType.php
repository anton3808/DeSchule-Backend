<?php

namespace Modules\Study\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Orchid\Screen\AsSource;

class LessonElementType extends Model
{
    use Translatable, AsSource;

    public static array $typeSlugs = [
        'read_and_translate', // Прочитать и перевести текс
        'read_and_insert', // Прочитать и перевести текс
        'read_and_answer', // Прочитать и перевести текс
    ];

    protected $fillable = ['slug'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        self::creating(function (LessonElementType $lessonElementType) {
            if ($lessonElementType->getAttribute('slug') === null) {
                $lessonElementType->setAttribute('slug', Str::random());
            }
        });
    }

    public $translatedAttributes = ['title', 'description'];

    /**
     * The attributes for which you can use filters in url.
     *
     * @var array
     */
    protected $allowedFilters = [
        'id',
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

class LessonElementTypeTranslation extends Model
{
    public $timestamps = false;
}
