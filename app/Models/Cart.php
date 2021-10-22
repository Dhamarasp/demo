<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Cart
 */
class Cart extends Model
{
    protected $table = 'carts';

    protected $primaryKey = 'cart_id';

    public $timestamps = true;
    
    protected $fillable = [
        'customer_id',
        'shipping_address_id',
        'shipping_service_id',
        'payment_method',
        'voucher_id',
        'discount'
    ];

    protected $guarded = [];

    public function voucher(){
        return $this->belongsTo('App\Models\Voucher', 'voucher_id');
    }
}