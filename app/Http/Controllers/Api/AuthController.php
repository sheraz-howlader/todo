<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(AuthRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if($user){
            $user['full_name'] = $user->full_name;
        }

        if (!$user || !Hash::check($request->password, $user->password)) {
            $response = [
                'message' => 'Access denied. Wrong password.'
            ];
            return response()->json($response);
        }

        $token = $user->createToken('apiToken')->plainTextToken;
        Cookie::queue(Cookie::make('access_token', $token, 1440, '/', null, true, true));

        $response = [
            'success' => true,
            'user'    => $user,
            'token'   => $token,
            'message' => 'You have successfully logged in!'
        ];

        return response()->json($response, 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        $response = [
            'success' => true,
            'message' => 'You have been securely logged out'
        ];
        return response()->json($response)->withCookie(Cookie::forget('access_token'));
    }
}
