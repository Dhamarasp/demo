<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Province
 */
class Province extends Model
{
    protected $table = 'provinces';

    protected $primaryKey = 'province_id';

	public $timestamps = true;

    protected $fillable = [
        'province_code',
        'province_name',
        'is_active'
    ];

    protected $guarded = [];

}