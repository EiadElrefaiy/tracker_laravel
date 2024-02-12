<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class RegisterController extends Controller
{
    use RegistersUsers;

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function create(Request $request)
    {
        $data = $request->all();
    
        $validator = Validator::make($data, [
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    
        if ($validator->fails()) {
            return response()->json(['status' => false,'error' => $validator->errors()], 422);
        }
    
        // Validation passed, create the user
        $user = User::create([
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
        ]);
    
        // Generate JWT token for the newly registered user
        $token = JWTAuth::fromUser($user);
    
        return response()->json([
            'status' => true,
            'message' => 'User registered successfully',
             'user' => $user ,
             'token' => $token
            ]);
      }
    }
