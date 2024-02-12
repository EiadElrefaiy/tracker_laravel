<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Tracked;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterTrackedController extends Controller
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
            'username' => ['required', 'string', 'max:255', 'unique:tracked'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validator->errors()], 422);
        }
    
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = substr(str_shuffle($characters), 0, 10);

        // Validation passed, create the user
        $tracked = Tracked::create([
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'location_long' => 0.000000,
            'location_lat' => 0.000000,
            'deviceID' => $randomString,
        ]);
    
        // Generate JWT token for the newly registered user
        $token = JWTAuth::fromUser($tracked);
    
        return response()->json([
            'status' => true,
            'message' => 'Tracked registered successfully',
             'tracked' => $tracked ,
             'token' => $token
            ]);
      }
    }