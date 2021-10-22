<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class FinanceCategory
 */
class FinanceCategory extends Model
{
    use SoftDeletes;
    
    protected $table = 'finance_categories';

    protected $primaryKey = 'finance_category_id';

	public $timestamps = true;

    protected $fillable = [
        'finance_category_name',
        'is_editable'
    ];

    protected $guarded = [];

}