<?php

namespace App\Helper;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class JWTToken
{
    public static function CreateToken($userEmail, $userID, $type, $status, $userName){
        $key =env("JWT_KEY");
        $payload=[
            "iss"=>"token_laraverlevel",
            "iat"=>time(),
            "exp"=>time()+24*60*60,
            "userEmail"=>$userEmail,
            "userID"=>$userID,
            "type"=>$type,
            "status"=>$status,
            "name"=>$userName
        ];
        //return $payload;
        return JWT::encode($payload,$key,"HS256");
    }

    public static function ReadToken($token){
        try {
            if($token==null){
                return "unauthorized";
            }
            else{
                $key =env("JWT_KEY");
                return JWT::decode($token,new Key($key,"HS256"));
            }
        }
        catch (Exception $e){
            return "unauthorized";
        }
    }

    public static function CreateTokenForSetPassword($userEmail){
        $key = env("JWT_KEY");
        $payload = [
            "iss" => "token",
            "iat" => time(),
            "exp" => time()+60*20,
            "userEmail" => $userEmail,
            "userId" => "0"
        ];
        
        return JWT::encode($payload,$key,"HS256");
    }
}