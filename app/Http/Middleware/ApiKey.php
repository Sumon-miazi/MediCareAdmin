<?php

namespace App\Http\Middleware;

use Closure;

class ApiKey
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
        $status = false;
        if(!$request->has('api_key')){
            echo json_encode(['success' => $status,'message' => 'api key needed']);
            exit();
        }
        else if(trim($request->api_key,'"') != env('API_KEY')){
            echo json_encode(['success' => $status,'message' => 'wrong api key']);
            exit();
        }
        return $next($request);
    }
}
