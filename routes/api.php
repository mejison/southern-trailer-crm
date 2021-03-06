<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('message', [App\Http\Controllers\VoIpController::class, 'getMessages']);
Route::post('message', [App\Http\Controllers\VoIpController::class, 'send']);

// sms alert
Route::get('sms-alert', [App\Http\Controllers\VoIpController::class, 'sendSMSAlert']);
