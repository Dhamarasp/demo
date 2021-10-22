<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ProductionPlanProgress
 */
class ProductionPlanProgress extends Model
{
    use SoftDeletes;
    
    protected $table = 'production_plan_progresses';

    protected $primaryKey = 'production_plan_progress_id';

	public $timestamps = true;

    protected $fillable = [
        'production_plan_id',
        'production_plan_progress_update',
        'production_plan_progress_note'
    ];

    protected $guarded = [];

}