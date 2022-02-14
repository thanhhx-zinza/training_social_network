<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionChecker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $roles)
    {
        $allowRoles = explode('|',$roles);
        if (in_array(Auth::user()->getStrRole(),$allowRoles)) {
            return $next($request); 
        }
        return redirect(url('admin/403'));
    }
}
