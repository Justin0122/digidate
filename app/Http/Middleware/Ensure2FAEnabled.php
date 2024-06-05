<?php

namespace App\Http\Middleware;

use App\Notifications\Enable2FA;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class Ensure2FAEnabled
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(object $request, object $next)
    {
        if ($request->user() && ! $request->user()->two_factor_confirmed_at) {
            try {
                $request->user()->notify(new Enable2FA());
            } catch (\Exception $e) {
                // do nothing
            }
            $redirect = Redirect::route('profile.show');
            $redirect->setTargetUrl($redirect->getTargetUrl().'#2fa');

            return $redirect;
        } else {
            $request->user()->notifications()->where('type', 'App\Notifications\Enable2FA')->delete();
        }

        return $next($request);
    }
}
