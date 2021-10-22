<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Post
 */
class Post extends Model
{
    use SoftDeletes;
    
    protected $table = 'posts';

    protected $primaryKey = 'post_id';

	public $timestamps = true;

    protected $fillable = [
        'post_category_id',
        'post_image_url',
        'post_title',
        'post_content'
    ];

    protected $guarded = [];

}