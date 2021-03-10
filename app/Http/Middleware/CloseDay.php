<?php

namespace App\Http\Middleware;

use App\db_close_day;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Auth;

class CloseDay
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
        $close_day = db_close_day::whereDate('created_at', Carbon::now()->toDateString())
            ->where('id_agent', Auth::id())
            ->first();

        if($close_day){
            return redirect('home');
        }

        return $next($request);
    }
}
