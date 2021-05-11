<?php

namespace App\Http\Middleware;
use Jenssegers\Agent\Agent;
use Closure;

class Device
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
        $agent = new Agent();
        $device = ($agent->isMobile() || $agent->isTablet()) ? 'Móvil' : 'Escritorio';
        $request['device'] = $device;

        return $next($request);
    }
}
