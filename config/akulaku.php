<?php
return[
	'development_secret' => env('AKULAKU_SANDBOX_SECRET',''),	
	'development_appid' => env('AKULAKU_SANDBOX_APPID',''),	
	'production_secret' => env('AKULAKU_PRODUCTION_SECRET',''),	
	'production_appid' => env('AKULAKU_PRODUCTION_APPID',''),
	'development_useraccount' => env('AKULAKU_SANDBOX_USERACCOUNT',''),	
	'production_useraccount' => env('AKULAKU_PRODUCTION_USERACCOUNT',''),	
	'production' => env('AKULAKU_PRODUCTION',false)
];