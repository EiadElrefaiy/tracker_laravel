<?php

namespace App\Http\Controllers\Device;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Tracked;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UpdateDeviceController extends Controller
{
    public function update(Request $request)
    {

        $tracked_id = Tracked::where("deviceID" , $request->deviceID)->pluck("id")[0];
        $tracked = Tracked::find($tracked_id);
        $tracked->update([
            'location_lat' => $request->lat,
            'location_long' => $request->long,
        ]);

        return response()->json(['message' => 'Device updated successfully', 'tracked' => $tracked]);
    }
}
