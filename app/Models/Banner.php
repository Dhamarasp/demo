<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Banner
 */
class Banner extends Model
{

    use SoftDeletes;

    protected $table = 'banners';

    protected $primaryKey = 'banner_id';

	public $timestamps = true;

    protected $fillable = [
        'banner_type_id',
        'banner_url',
        'banner_image_url'
    ];

    protected $guarded = [];

}