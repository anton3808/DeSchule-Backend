<?php

namespace App\Models\Challenge;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class ChallengeExercise extends Model
{
    use AsSource;

    protected $table = 'challenge_exercise';

    protected $fillable = [
        'challenge_id',
        'location',
        'main_line',
        'character_id',
        'image',
        'content',
        'audio',
    ];

    public function challenge()
    {
        return $this->hasOne(Challenge::class, 'id', 'challenge_id');
    }

    public function character()
    {
        return $this->hasOne(Character::class, 'id', 'character_id');
    }
}
