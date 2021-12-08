<?php

namespace Modules\Study\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Orchid\Screen\AsSource;

/**
 * Class LessonElementType
 * @package Modules\Study\Entities
 *
 * @property string $title
 * @property string $description
 */
class LessonElementType extends Model
{
    use Translatable, AsSource;

    public static array $typeSlugs = [
        'read_and_translate', // Прочитать и перевести текс
        'read_and_insert', // Прочитать и вставить пропущенные слова
        'read_and_answer', // Прочитать и ответить на вопрос
        'translate_words', // Перевести слова
        'watch_video_and_answer', // Посмотреть видео и ответить на вопросы
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
