<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth; // Ensure this import is present
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['status' => false ,'error' => 'Invalid email or password'], 401);
        }

        $user = Auth::user(); // Retrieve the authenticated user

        // You can customize the user data you want to return in the response
        $userData = [
            'id' => $user->id,
            'username' => $user->username,
            // Add more user attributes as needed
        ];

        return response()->json(['status' => true ,'token' => $token, 'user' => $userData], 200);
    }

}
