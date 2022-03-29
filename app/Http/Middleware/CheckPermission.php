<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Auth;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $keyCode = null)
    {
        $roles = Auth::guard("admin")->user()->roles;
        foreach ($roles as $role) {
            $permissions = $role->permissions;
            if ($permissions->contains("key_code", $keyCode)) {
                return $next($request);
            }
        }
        return abort(403);
    }
}
