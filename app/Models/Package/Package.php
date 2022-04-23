<?php

namespace App\Models\Package;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Screen\AsSource;

class Package extends Model
{
    use Translatable, AsSource;

    protected $table = 'package';

    protected $fillable = ['image', 'price', 'type', 'status', 'available_in_tariff_id'];

    public $translatedAttributes = ['title', 'description'];

    /**
     * The attributes for which you can use filters in url.
     *
     * @var array
     */
    protected $allowedFilters = [
        'id',
        'price',
        'type',
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
        'price',
        'type',
        'status',
        'updated_at',
        'created_at',
    ];

    public function options(): HasMany
    {
        return $this->hasMany(PackageOption::class, 'package_id', 'id');
    }

    public function getOrchidTagAttribute(): string
    {
        return "#$this->id $this->title";
    }
}
