<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class City
 */
class City extends Model
{
    protected $table = 'cities';

    protected $primaryKey = 'city_id';

	public $timestamps = true;

    protected $fillable = [
        'province_id',
        'city_code',
        'city_name',
        'is_active'
    ];

    protected $guarded = [];

}