<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ShippingAddress
 */
class ShippingAddress extends Model
{
    protected $table = 'shipping_addresses';

    protected $primaryKey = 'shipping_address_id';

    public $timestamps = true;
    
    protected $fillable = [
        'customer_id',
        'shipping_address_name',
        'shipping_address_customer_name',
        'shipping_address_phone',
        'shipping_address_text',
        'province_id',
        'city_id',
        'district_id',
        'postal_code',
        'map_coordinate',
        'is_active'
    ];

    protected $guarded = [];
    
    public function city(){
        return $this->belongsTo('App\Models\City', 'city_id');
    }
    
    public function district(){
        return $this->belongsTo('App\Models\District', 'district_id');
    }

    public function province(){
        return $this->belongsTo('App\Models\Province', 'province_id');
    }

}