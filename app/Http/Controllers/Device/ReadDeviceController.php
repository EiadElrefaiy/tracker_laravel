<?php

namespace App\Http\Controllers\Device;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Tracked;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class ReadDeviceController extends Controller
{
    public function index()
    {
        $devices = Device::all();

        return response()->json(['devices' => $devices]);
    }

    public function show($device_id)
    {
        $device = Device::find($device_id);
        $tracked = Tracked::where('deviceID' , $device->deviceID)->get();
        return response()->json(['tracked' => $tracked]);
    }

    public function showUserDevices(Request $request)
    {
        $token = $request->bearerToken();

        $decoded = JWTAuth::setToken($token)->getPayload();

        $user_id = $decoded['sub'];

        $devices = Device::where("user_id" , $user_id)->get();

        return response()->json(['devices' => $devices]);
    }

    public function showTracekedDevices(Request $request)
    {
        $token = $request->bearerToken();

        $decoded = JWTAuth::setToken($token)->getPayload();

        $tracked_id = $decoded['sub'];

        $devices = Device::where("tracked_id" , $tracked_id)->get();

        return response()->json(['devices' => $devices]);
    }
}
