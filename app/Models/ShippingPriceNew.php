<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ShippingPriceNew
 */
class ShippingPriceNew extends Model
{
    protected $table = 'shipping_prices_new';

    protected $primaryKey = 'shipping_price_new_id';

    public $timestamps = true;
    
    protected $fillable = [
        'shipping_service_id',
        'destination',
        'shipping_price_unit',
        'shipping_etl',
        'is_active'
    ];

    protected $guarded = [];

}