<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ProductionPlan
 */
class ProductionPlan extends Model
{
    use SoftDeletes;
    
    protected $table = 'production_plans';

    protected $primaryKey = 'production_plan_id';

	public $timestamps = true;

    protected $fillable = [
        'product_id',
        'product_quantity',
        'production_plan_status',
        'transaction_id',
        'transaction_detail_id'
    ];

    protected $guarded = [];

}