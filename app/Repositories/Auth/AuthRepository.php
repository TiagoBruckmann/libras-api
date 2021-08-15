<?php

namespace App\Repositories\Auth;

# authentication
use Laravel\Passport\Token;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Token\Parser;

class AuthRepository
{
    
    public function getUserID($token)
    {
        if ($token == null || $token == '') {
            return response()->json([
                'message' => 'A request parameter is missing - bearerToken',
                'status_code' => 400
            ],400);
        }

        $user_id = (new Parser(new JoseEncoder()))->parse($token)->claims()->all()['sub'];
        
        return $user_id;
    }

}