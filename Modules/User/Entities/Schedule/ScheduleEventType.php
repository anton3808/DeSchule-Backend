<?php

namespace Modules\User\Entities\Schedule;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class ScheduleEventType extends Model
{
    use Translatable, AsSource;

    public static array $linked = [
        // event slug -> model table
        'lesson' => 'lessons'
    ];

    protected $fillable = ['slug'];

    public $translatedAttributes = ['title'];

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

class ScheduleEventTypeTranslation extends Model
{
    public $timestamps = false;
}
