<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ProductType
 */
class ProductType extends Model
{
    use SoftDeletes;
    
    protected $table = 'product_types';

    protected $primaryKey = 'product_type_id';

	public $timestamps = true;

    protected $fillable = [
        'product_type_name'
    ];

    protected $guarded = [];

}