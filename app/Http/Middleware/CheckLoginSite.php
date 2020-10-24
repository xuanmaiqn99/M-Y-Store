<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckLoginSite
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
        if (Auth::check()) {
            return $next($request);
        }

        return redirect()->route('site.customer.login')
            ->with('message', __('Vui lòng đăng nhập để thực hiện chức năng này'));
    }
}
