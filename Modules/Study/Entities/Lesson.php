<?php

namespace Modules\Study\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lesson extends Model
{
    use Translatable;

    protected $fillable = ['order', 'level_id'];

    public $translatedAttributes = ['title'];

    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class, 'id', 'level_id');
    }
}

class LessonTranslation extends Model
{
    public $timestamps = false;
}
