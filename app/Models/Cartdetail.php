<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CartDetail
 */
class CartDetail extends Model
{
    protected $table = 'cart_details';

    protected $primaryKey = 'cart_detail_id';

    public $timestamps = true;
    
    protected $fillable = [
        'cart_id',
        'product_id',
        'product_price',
        'product_quantity',
        'discount_id'
    ];

    protected $guarded = [];

}