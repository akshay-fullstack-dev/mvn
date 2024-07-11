<?php

namespace App\Http\Middleware;

use App\Enum\UserEnum;
use App\Exceptions\BlockedUserException;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserVendorRole
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
        $user = Auth::user();
        if ($user->role != UserEnum::user_vendor)
            throw new BlockedUserException(trans('Api/v1/auth.not_authorized_for_this_action'));
        return $next($request);
    }
}
