<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Warehouse
 */
class Warehouse extends Model
{
    use SoftDeletes;
    
    protected $table = 'warehouses';

    protected $primaryKey = 'warehouse_id';

	public $timestamps = true;

    protected $fillable = [
        'warehouse_name',
        'warehouse_note'
    ];

    protected $guarded = [];

}