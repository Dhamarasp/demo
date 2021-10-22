<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class District
 */
class District extends Model
{
    protected $table = 'districts';

    protected $primaryKey = 'district_id';

	public $timestamps = true;

    protected $fillable = [
        'city_id',
        'district_code',
        'district_name',
        'regular_price',
        'regular_etl',
        'yes_price',
        'yes_etl',
        'is_active'
    ];

    protected $guarded = [];

}