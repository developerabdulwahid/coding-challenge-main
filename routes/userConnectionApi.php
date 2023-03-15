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

Route::group(['middleware' => 'auth:sanctum'], function () {
	Route::get('/get-suggestions', [App\Http\Controllers\NetworkConnectionController::class, 'getSuggestions']);
	Route::post('/connect', [App\Http\Controllers\NetworkConnectionController::class, 'connect']);

	Route::get('/get-sent-requests', [App\Http\Controllers\NetworkConnectionController::class, 'getSentRequests']);
	Route::post('/withdraw-request', [App\Http\Controllers\NetworkConnectionController::class, 'withdrawRequest']);

	Route::get('/get-received-requests', [App\Http\Controllers\NetworkConnectionController::class, 'getReceivedRequests']);

	Route::post('/accept-request', [App\Http\Controllers\NetworkConnectionController::class, 'acceptRequest']);

	Route::get('/get-connections', [App\Http\Controllers\NetworkConnectionController::class, 'getConnections']);

	Route::post('/remove-connection', [App\Http\Controllers\NetworkConnectionController::class, 'removeConnection']);
});