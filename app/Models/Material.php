<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Material
 */
class Material extends Model
{
    use SoftDeletes;
    
    protected $table = 'materials';

    protected $primaryKey = 'material_id';

	public $timestamps = true;

    protected $fillable = [
        'material_name',
        'material_note',
        'material_unit',
        'material_quantity'
    ];

    protected $guarded = [];

    

    


}