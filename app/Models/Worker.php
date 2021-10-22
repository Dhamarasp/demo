<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Worker
 */
class Worker extends Model
{
    use SoftDeletes;
    
    protected $table = 'workers';

    protected $primaryKey = 'worker_id';

	public $timestamps = true;

    protected $fillable = [
        'username',
        'password',
        'remember_token',
        'role_id'
    ];

    protected $guarded = [];

}