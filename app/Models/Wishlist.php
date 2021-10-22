<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * Class Wishlist
 */
class Wishlist extends Model
{
    protected $table = 'wishlists';

    protected $primaryKey = 'wishlist_id';

	public $timestamps = false;

    protected $fillable = [
        'customer_id',
        'product_id'
    ];

    protected $guarded = [];

}