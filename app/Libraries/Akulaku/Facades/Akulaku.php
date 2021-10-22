<?php
namespace App\Libraries\Akulaku\Facades;
use Illuminate\Support\Facades\Facade;
/**
* 
*/
class Akulaku extends Facade
{
	/**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { 
    	return 'App\Libraries\Akulaku\Akulaku'; 
    }
}