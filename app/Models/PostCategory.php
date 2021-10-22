<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PostCategory
 */
class PostCategory extends Model
{
    use SoftDeletes;
    
    protected $table = 'post_categories';

    protected $primaryKey = 'post_category_id';

	public $timestamps = true;

    protected $fillable = [
        'post_category_name',
        'post_category_type',
        'is_editable'
    ];

    protected $guarded = [];

}