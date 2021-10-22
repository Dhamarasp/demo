<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ProductImage
 */
class ProductImage extends Model
{
    use SoftDeletes;
    
    protected $table = 'product_images';

    protected $primaryKey = 'product_image_id';

	public $timestamps = true;

    protected $fillable = [
        'product_id',
        'product_image_url',
        'product_image_order'
    ];

    protected $guarded = [];

}