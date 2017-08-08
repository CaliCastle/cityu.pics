<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class RedirectIfNotConfirmed
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
        if (Auth::guest())
            return redirect('/login');

        if ($request->user()->hasConfirmed())
            return $next($request);

        return redirect('locked');
    }
}
