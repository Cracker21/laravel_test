<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

\Debugbar::disable();
Route::get('/', function(){
	return redirect('deal');
});

Route::get('result', function(){
	return view('result', ['res' => session('result')]);
});

Route::get('deal', 'App\Http\Controllers\ZohoCRMController@dealForm');
Route::post('create', 'App\Http\Controllers\ZohoCRMController@create');

Route::get('auth', function(){
	return view('auth');
});

Route::post('auth', 'App\Http\Controllers\ZohoAuthController@auth');
Route::get('logout', 'App\Http\Controllers\ZohoAuthController@logout');

