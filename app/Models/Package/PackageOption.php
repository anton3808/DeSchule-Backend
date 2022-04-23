<?php

namespace App\Models\Package;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class PackageOption extends Model
{
    use Translatable, AsSource;

    protected $table = 'package_option';

    protected $fillable = ['package_id', 'type', 'status'];

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
}
