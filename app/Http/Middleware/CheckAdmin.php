<?php

namespace App\Http\Middleware;

use Closure;

class CheckAdmin
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
        $user = auth()->user();
        if($user->isAdmin)
            return Response(['message' => "تقلع حفظك الله مسوي ادمن اجل"], 401);
        else
            return $next($request);
    }
}
