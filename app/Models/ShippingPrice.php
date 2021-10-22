<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ShippingPrice
 */
class ShippingPrice extends Model
{
    protected $table = 'shipping_prices';

    protected $primaryKey = 'shipping_price_id';

    public $timestamps = true;
    
    protected $fillable = [
        'district_id',
        'shipping_service_id',
        'shipping_price_unit',
        'shipping_etl',
        'is_active'
    ];

    protected $guarded = [];

}