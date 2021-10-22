<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ShippingService
 */
class ShippingService extends Model
{
    protected $table = 'shipping_services';

    protected $primaryKey = 'shipping_service_id';

    public $timestamps = true;
    
    protected $fillable = [
        'shipping_service_name',
        'image_url',
        'is_active'
    ];

    protected $guarded = [];

}