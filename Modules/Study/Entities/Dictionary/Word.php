<?php

namespace Modules\Study\Entities\Dictionary;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Word extends Model
{
    use Translatable, AsSource;

    protected $fillable = ['word', 'description', 'image'];

    public $translatedAttributes = ['word_translation', 'word_description_translation'];

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
        'order',
        'updated_at',
        'created_at',
    ];
}

class WordTranslation extends Model
{
    public $timestamps = false;
}
