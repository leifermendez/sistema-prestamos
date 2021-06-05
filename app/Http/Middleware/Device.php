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
        $url = 'https://api.ipregistry.co/'.'186.90.111.220'.'?key=q49696zvy4aq1y';
        //  Initiate curl
        $ch = curl_init();
        // Will return the response, if false it print the response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Set the url
        curl_setopt($ch, CURLOPT_URL, $url);
        // Execute
        $result=curl_exec($ch);
        // Closing
        curl_close($ch);

        $result = json_decode($result);

        // Will dump a beauty json :3

        $device = array(
            'Dispositivo' => $a,
            'Tipo' => $agent->device(),
            'Ip' => $geoIp['ip'],
            'plataforma' => $agent->platform(),
            'Direccion' => $result->location->city,
            'Mapa' => 'https://www.google.com/maps/search/?api=1&query='.$result->location->latitude.','.$result->location->longitude,
            'Coordenadas' => $result->location->latitude.','.$result->location->longitude,
        );

        $request['device'] = json_encode($device);

        return $next($request);
    }
}
