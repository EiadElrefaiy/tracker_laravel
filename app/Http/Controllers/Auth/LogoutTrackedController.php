<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutTrackedController extends Controller
{
    public function logout(Request $request)
    {
        Auth::guard('tracked')->user()->token()->revoke();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
