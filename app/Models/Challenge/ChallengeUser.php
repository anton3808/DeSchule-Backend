<?php

namespace App\Models\Challenge;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class ChallengeUser extends Model
{
    use AsSource;

    protected $table = 'challenge_user';

    protected $fillable = [
        'challenge_id',
        'user_id',
        'progress',
        'status',
    ];

    public function challenge()
    {
        return $this->hasOne(Challenge::class, 'id', 'challenge_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
