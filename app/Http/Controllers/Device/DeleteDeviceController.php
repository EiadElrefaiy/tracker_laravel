<?php

namespace App\Http\Controllers\Device;

use App\Http\Controllers\Controller;
use App\Models\Device;

class DeleteDeviceController extends Controller
{
    public function delete($device_id)
    {
        $device = Device::find($device_id);

        $device->delete();

        return response()->json(['message' => 'Device deleted successfully']);
    }
}
