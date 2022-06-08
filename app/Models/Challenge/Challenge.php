<?php

namespace App\Models\Challenge;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Study\Entities\Level;
use Orchid\Screen\AsSource;

class Challenge extends Model
{
    use Translatable, AsSource;

    protected $table = 'challenge';

    public $translatedAttributes = ['title'];

    protected $fillable = [
        'order',
        'level_id',
        'dt',
        'status',
    ];

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

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function level()
    {
        return $this->hasOne(Level::class, 'id', 'level_id');
    }
}
