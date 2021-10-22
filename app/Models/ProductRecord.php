<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ProductRecord
 */
class ProductRecord extends Model
{
    use SoftDeletes;
    
    protected $table = 'product_records';

    protected $primaryKey = 'product_record_id';

	public $timestamps = true;

    protected $fillable = [
        'product_id',
        'product_record_status',
        'quntity'
    ];

    protected $guarded = [];

}