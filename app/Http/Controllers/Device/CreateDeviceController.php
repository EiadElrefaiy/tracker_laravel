<?php

namespace App\Http\Controllers\Device;

use App\Http\Controllers\Controller;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Tracked;
use Tymon\JWTAuth\Facades\JWTAuth;

class CreateDeviceController extends Controller
{
    public function create(Request $request)
    {
        $token = $request->bearerToken();

        $decoded = JWTAuth::setToken($token)->getPayload();

        $user_id = $decoded['sub'];

        $validator = Validator::make($request->all(), [
            'deviceID' => ['required', 'string', 'exists:tracked,deviceID']
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $tracked_id = Tracked::where('deviceID' , $request->deviceID)->pluck("id")[0];
        $tracked = Tracked::find($tracked_id);
        $device = Device::create([
            'user_id' => $user_id,
            'tracked_id' => $tracked->id,
            'notification' => 0,
            'name' => $request->name,
            'deviceID' => $tracked->deviceID,
        ]);

        return response()->json(['message' => 'Device created successfully', 'device' => $device]);
    }
}
