<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if(trim(request()->route()->getPrefix(),'/') == config('basic.adminPrefix')){
            return route('admin.login.show');
        }elseif(trim(request()->route()->getPrefix(),'/') == config('basic.consumerPrefix')){
            return route('consumer.login.show');
        }else{
            if (!$request->expectsJson()) {
                if(!Auth::user()){
                    return route('unAuthenticated');
                }
            }
        }

    }
}
