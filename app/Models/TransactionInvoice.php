<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TransactionInvoice
 */
class TransactionInvoice extends Model
{
    protected $table = 'transaction_invoices';

    protected $primaryKey = 'transaction_invoice_id';

    public $timestamps = true;
    
    protected $fillable = [
        'transaction_invoice_number',
        'transaction_id',
        'payment_log_id',
        'transaction_invoice_value',
        'transaction_invoice_name',
        'transaction_invoice_status',
        'pay_at',
        'transaction_invoice_amount',
        'transaction_invoice_balance',
        'akulaku_checkout_url',
        'kredivo_checkout_url',
        'kredivo_trx',
        'signature_key',
        'is_checked'
    ];

    protected $guarded = [];

}