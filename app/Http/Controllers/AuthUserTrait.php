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

    private function cekOwnership($owner)
    {
        $user = $this->getAuthUser();
        if ($user->id != $owner) {
            response()->json(['message' => 'Not Authorized'], 403)->send();
            exit;
        }
    }
}
