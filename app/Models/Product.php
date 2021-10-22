<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Product
 */
class Product extends Model
{
    use SoftDeletes;
    
    protected $table = 'products';

    protected $primaryKey = 'product_id';

	public $timestamps = true;

    protected $fillable = [
        'product_type_id',
        'product_code',
        'product_name_id',
        'product_name_en',
        'product_description_id',
        'product_description_en',
        'product_stock',
        'product_pending_stock',
        'product_sold',
        'product_weight',
        'product_length',
        'product_width',
        'product_height',
        'product_production_price',
        'product_selling_price',
        'product_diskon_price',
        'product_start_date_diskon_price',
        'product_end_date_diskon_price'
    ];

    protected $guarded = [];

    public function product_type(){
        return $this->belongsTo('App\Models\ProductType', 'product_type_id');
    }
}