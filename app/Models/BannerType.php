<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class BannerType
 */
class BannerType extends Model
{

    use SoftDeletes;

    protected $table = 'banner_types';

    protected $primaryKey = 'banner_type_id';

	public $timestamps = true;

    protected $fillable = [
        'banner_type_name'
    ];

    protected $guarded = [];

}