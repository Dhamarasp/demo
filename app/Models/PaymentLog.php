<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PaymentLog
 */
class PaymentLog extends Model
{
    protected $table = 'payment_logs';

    protected $primaryKey = 'payment_log_id';

    public $timestamps = false;
    
    protected $fillable = [
        'transaction_invoice_id',
        'payment_log_content',
        'created_at'
    ];

    protected $guarded = [];

}