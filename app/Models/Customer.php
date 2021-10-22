<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class Customer
 */
class Customer extends Authenticatable
{
    use SoftDeletes;
    
    protected $table = 'customers';

    protected $primaryKey = 'customer_id';

	public $timestamps = true;

    protected $fillable = [
        'customer_email',
        'customer_phone',
        'customer_name',
        'customer_birthday',
        'customer_gender',
        'customer_address',
        'customer_institution',
        'customer_status',
        'customer_poin',
        'customer_key'
    ];

    protected $guarded = [];

}