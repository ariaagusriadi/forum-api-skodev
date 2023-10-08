<?php

namespace App\Http\Controllers;

trait AuthUserTrait
{
    private function getAuthUser()
    {
        try {
            return auth()->userOrFail();
        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            response()->json(['message' => 'not authenticated, you have to login first'])->send();
            exit;
        }
    }
}
