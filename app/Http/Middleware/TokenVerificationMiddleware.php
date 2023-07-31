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
        
        
        if($result=='unauthorized' || $result==null)
        {
              return redirect('/userLogin');
            
                // return response()->json([
                //     'status' => 'Na',
                //     'message' => 'Unauthorized'
                // ],401);
            
        }

        $request->headers->set('email',$result->user_email);
        $request->headers->set('id',$result->user_id);

        return $next($request);
    }
}
