<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;

use App\Http\Controllers\Auth\RegisterTrackedController;
use App\Http\Controllers\Auth\LoginTrackedController;
use App\Http\Controllers\Auth\LogoutTrackedController;

use App\Http\Controllers\Device\CreateDeviceController;
use App\Http\Controllers\Device\ReadDeviceController;
use App\Http\Controllers\Device\UpdateDeviceController;
use App\Http\Controllers\Device\DeleteDeviceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [RegisterController::class, 'create']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/register-tracked', [RegisterTrackedController::class, 'create']);
Route::post('/login-tracked', [LoginTrackedController::class, 'login']);


Route::group(['middleware' => ['api' , 'jwt'] ,'prefix' =>'user'] , function(){
    Route::post('/logout', [LogoutController::class, 'logout']);

    // Create
    Route::post('/create-device', [CreateDeviceController::class, 'create']);

    // Read
    Route::get('/devices', [ReadDeviceController::class, 'index']);
    Route::get('/device/{device_id}', [ReadDeviceController::class, 'show']);
    Route::post('/user-devices', [ReadDeviceController::class, 'showUserDevices']);
    Route::post('/tracked-devices', [ReadDeviceController::class, 'showTracekedDevices']);

    // Update

    // Delete
    Route::post('/delete-devices/{device_id}', [DeleteDeviceController::class, 'delete']);
});

Route::group(['middleware' => ['api' , 'tracked-api'] ,'prefix' =>'tracked'] , function(){

    Route::post('/logout-tracked', [LogoutTrackedController::class, 'logout']);

    Route::post('/update-devices', [UpdateDeviceController::class, 'update']);
});
