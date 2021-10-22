<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class CheckCustomerStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()){
            $customer = Auth::user();
            if($customer->customer_status != 2) {
                return response()->view('pages/account/register', ['customer' => $customer]);
            }
        }

        return $next($request);
    }
}