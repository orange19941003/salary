<?php

namespace App\Http\Middleware;

use Closure;

class CheckLogin
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
        if (!session('admin_id') && $request->route()->uri != 'admin/login')
        {
            return  redirect('login');
        }
        
        return $next($request);
    }
}
