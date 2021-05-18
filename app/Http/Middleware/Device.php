<?php

namespace App\Http\Middleware;
use Jenssegers\Agent\Agent;
use Closure;
use Torann\GeoIP\Facades\GeoIP;

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
        $a = ($agent->isMobile() || $agent->isTablet()) ? 'Móvil' : 'Escritorio';
        $geoIp = GeoIP::getLocation($request->ip());

        $device = array(
            'Dispositivo' => $a,
            'Tipo' => $agent->device(),
            'Ip' => $geoIp['ip'],
            'Direccion' => $geoIp['state_name'],
            'Coordenadas' => 'lat: '.$geoIp['lat'].', lng: '.$geoIp['lon'],
        );
//        print_r(json_encode($device));

        $request['device'] = json_encode($device);

        return $next($request);
    }
}
