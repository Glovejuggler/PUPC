<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;

class AdminCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $data = ['LoggedUserInfo'=>User::where('id', '=', session('LoggedUser'))->first()];
        if($data['LoggedUserInfo']->role != 'Admin'){
            return redirect()->back();
        }

        return $next($request);
    }
}
