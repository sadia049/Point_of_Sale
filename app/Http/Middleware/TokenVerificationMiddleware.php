<?php

namespace App\Http\Middleware;

use App\Helper\JWT_TOKEN;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenVerificationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->cookie('token');
        $result = JWT_TOKEN::verify_token($token);
        
        echo $result;
        if($result=='unauthorized')
        {
            
                return response()->json([
                    'status' => 'Na',
                    'message' => 'Unauthorized'
                ],401);
            
        }
        $request->headers->set('email',$result);
        

        return $next($request);
    }
}
