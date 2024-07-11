<?php

namespace App\Http\Middleware;

use App\Enum\UserEnum;
use App\Exceptions\BlockedUserException;
use Closure;
use Illuminate\Support\Facades\Auth;

class BeforeCheckUserBlocked
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
        if (Auth::user()->is_blocked == UserEnum::blocked_user)
            throw new BlockedUserException(trans('Api/v1/auth.you_are_blocked_by_admin'));
        return $next($request);
    }
}
