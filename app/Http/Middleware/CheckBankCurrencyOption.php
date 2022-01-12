<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckBankCurrencyOption
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
        if (auth('bank')->user()->allow_curency_edit) {
            return $next($request);
        }
        return abort(403);
    }
}
