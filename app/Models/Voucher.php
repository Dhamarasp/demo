<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Voucher
 */
class Voucher extends Model
{
    use SoftDeletes;
    
    protected $table = 'vouchers';

    protected $primaryKey = 'voucher_id';

	public $timestamps = true;

    protected $fillable = [
        'voucher_code',
        'voucher_quantity',
        'voucher_used',
        'voucher_start_date',
        'voucher_end_date',
        'voucher_minimal_subtotal',
        'voucher_maximal_subtotal',
        'voucher_discount',
        'voucher_type'
    ];

    protected $guarded = [];

}