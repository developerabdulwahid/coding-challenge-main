<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| User Connection Routes
|--------------------------------------------------------------------------
|
|
*/

Route::group(['middleware' => ['auth']], function () {
	Route::get('/network-connection', [App\Http\Controllers\NetworkConnectionController::class, 'index'])->name('network-connection');

	if(!request()->ajax()){
		Route::get('{any}', function () {
		    return view('network-connection');
		})->where('any','.*');
    }
});