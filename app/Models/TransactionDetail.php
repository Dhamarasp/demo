<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TransactionDetail
 */
class TransactionDetail extends Model
{
    protected $table = 'transaction_details';

    protected $primaryKey = 'transaction_detail_id';

    public $timestamps = true;
    
    protected $fillable = [
        'transaction_id',
        'product_id',
        'product_price',
        'product_quantity',
        'discount_id'
    ];

    protected $guarded = [];

}