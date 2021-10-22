<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Finance
 */
class Finance extends Model
{
    use SoftDeletes;
    
    protected $table = 'finances';

    protected $primaryKey = 'finance_id';

	public $timestamps = true;

    protected $fillable = [
        'finance_number',
        'finance_type',
        'finance_category_id',
        'finance_note',
        'finance_nominal'
    ];

    protected $guarded = [];

}