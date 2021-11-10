<?php

namespace Modules\Study\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Level extends Model
{
    use Translatable;

    protected $fillable = ['priority', 'code'];

    public $translatedAttributes = ['title'];

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class, 'level_id', 'id');
    }
}

class LevelTranslation extends Model
{
    public $timestamps = false;
}
