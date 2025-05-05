<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'     => 'required|email',
            'password'  => 'required'
        ]);

        $user = User::where('email', $request->email)->first();
        if($user){
            $user['full_name'] = $user->full_name;
        }

        if (!$user || !Hash::check($request->password, $user->password)) {
            $response = [
                'message' => 'Email or Password is wrong'
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
}
