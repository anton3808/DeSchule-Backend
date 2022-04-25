<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

use App\Models\Package\Package;

class Payment extends Model
{
    use AsSource;

    protected $table = 'payment';

    protected $fillable = [
        'user_id',
        'package_id',
        'amount',
        'amount_type',
        'pay_from',
        'stream',
        'status',
        'active_before'
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

    public function package()
    {
        return $this->hasOne(Package::class, 'id', 'package_id');
    }

    public function getOrchidTagAttribute(): string
    {
        return "#$this->id";
    }

}
