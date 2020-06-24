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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/accounts', 'ApiController@accounts');
Route::get('/accounts/{id}', 'ApiController@availableaccounts');
Route::get('/regions', 'ApiController@regions');
Route::get('/convert/{price}/{curr}/{curr_sec}', 'ApiController@covert');
Route::get('/countrycode', 'ApiController@getCountryCode');



Route::get('/pay_stripe', 'PaymentController@pay_stripe');
Route::post('/pay_paypal', 'PaymentController@pay_paypal')->name('charge');
Route::get('paymentsuccess', 'PaymentController@payment_success');
Route::get('paymenterror', 'PaymentController@payment_error');
