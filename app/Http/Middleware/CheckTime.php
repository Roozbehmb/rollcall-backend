<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\Response;

class CheckTime
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $now = Carbon::now();
//        dd($request);
        $start = Carbon::createFromTimeString('00:00');
        $end = Carbon::createFromTimeString('06:00');

        if ($now->between($start, $end))
        {
            return redirect('/not-available-now');
        }

        return $next($request);

    }




}
