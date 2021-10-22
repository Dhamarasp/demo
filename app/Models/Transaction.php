<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Transaction
 */
class Transaction extends Model
{
    protected $table = 'transactions';

    protected $primaryKey = 'transaction_id';

    public $timestamps = true;
    
    protected $fillable = [
        'transaction_number',
        'customer_id',
        'voucher_id',
        'transaction_status',
        'transaction_subtotal',
        'transaction_discount',
        'transaction_shipping_price',
        'transaction_pallet_price',
        'transaction_assurance',
        'payment_method',
        'paid_off_at',
        'shipping_address_id',
        'shipping_service_id',
        'is_checked'
    ];

    protected $guarded = [];

}