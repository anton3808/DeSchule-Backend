<?php

namespace App\Models\Challenge;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Character extends Model
{
    use AsSource;

    protected $table = 'character';

    protected $fillable = [
        'name'
    ];

}
