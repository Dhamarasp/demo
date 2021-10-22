<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Setting
 */
class Setting extends Model
{

    use SoftDeletes;

    protected $table = 'settings';

    protected $primaryKey = 'setting_id';

	public $timestamps = true;

    protected $fillable = [
        'setting_name',
        'setting_code',
        'setting_value'
    ];

    protected $guarded = [];

}