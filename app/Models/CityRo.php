<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CityRo
 */
class CityRo extends Model
{
    protected $table = 'cities_ro';

    protected $primaryKey = 'city_id';

	public $timestamps = false;

    protected $fillable = [
        'province_id',
        'province',
        'type',
        'city_name',
        'postal_code'
    ];

    protected $guarded = [];

}