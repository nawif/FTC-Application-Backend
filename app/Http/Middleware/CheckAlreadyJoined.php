<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class CheckAlreadyJoined
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
        $event = DB::table('users_events')->where('user_id', $user->id)->where('event_id', $request['event_id'])->first();

        if($event === null)
            return Response(['message' => "You can't record task in an event you're not in"], 401);
        else
            return $next($request);
    }
}
