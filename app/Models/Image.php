<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Image
 */
class Image extends Model
{
    use SoftDeletes;
    
    protected $table = 'images';

    protected $primaryKey = 'image_id';

	public $timestamps = true;

    protected $fillable = [
        'image_name',
        'image_url'
    ];

    protected $guarded = [];

    

    


}