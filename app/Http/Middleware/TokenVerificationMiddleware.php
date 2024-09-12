<?php

namespace App\Http\Middleware;

use Closure;
use App\Helper\JWTToken;
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
        $token = $request->cookie("Token");
        // return $token;
        $result = JWTToken::ReadToken($token);
        //return $result;

        if($result == "unauthorized"){
            //return $result;
            return redirect("/login");

        }
        else{
            $request->session()->put("email",$result->userEmail);
            $request->session()->put("id",$result->userID);
            $request->session()->put("type",$result->type);
            $request->session()->put("status",$result->status);
            $request->session()->put("name",$result->name);
            return $next($request);
        }
    }
}
