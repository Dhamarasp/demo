<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ShippingPricejtr
 */
class ShippingPricejtr extends Model
{
    protected $table = 'shipping_prices_jtr';

    protected $primaryKey = 'shipping_price_jtr_id';

    public $timestamps = true;
    
    protected $fillable = [
        'shipping_service_id',
        'city',
        'district',
        'price_1',
        'price_2',
        'price_3'
    ];

    protected $guarded = [];

}