<?php

namespace App\Models\Challenge;

use Illuminate\Database\Eloquent\Model;
use Modules\Study\Entities\Lesson;
use Orchid\Screen\AsSource;

class Challenge extends Model
{
    use AsSource;

    protected $table = 'challenge';

    protected $fillable = [
        'user_id',
        'lesson_id',
        'status',
    ];

    protected $casts = [
        'stream' => 'array'
    ];


    /**
     * The attributes for which you can use filters in url.
     *
     * @var array
     */
    protected $allowedFilters = [
        'id',
        'status',
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

    public function lesson()
    {
        return $this->hasOne(Lesson::class, 'id', 'lesson_id');
    }
}
