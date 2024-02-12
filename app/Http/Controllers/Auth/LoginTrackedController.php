<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth; // Ensure this import is present
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;

class LoginTrackedController extends Controller
{
    use AuthenticatesUsers;
    
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false , 'error' => $validator->errors()], 422);
        }

        $credentials = $request->only('username', 'password');

        if (!$token = auth('tracked-api')->attempt($credentials)) {
            return response()->json(['status' => false ,'error' => 'Invalid username or password'], 401);
        }
                
        // Use the 'tracked' guard to get the authenticated tracked user
        $tracked = Auth::guard('tracked-api')->user();

        // You can customize the tracked data you want to return in the response
        $trackedData = [
            'id' => $tracked->id,
            'username' => $tracked->username,
            'location_lat' => $tracked->location_lat,
            'location_long' => $tracked->location_long,
            'deviceID' => $tracked->deviceID,
            // Add more tracked attributes as needed
        ];

        return response()->json(['status' => true , 'token' => $token, 'tracked' => $trackedData], 200);
      }
    }
