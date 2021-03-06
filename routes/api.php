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

Route::group([

    'middleware' => ['cors'],

], function () {

    Route::get('/', 'HomeController@index');
    Route::get('/accounts', 'AccountsController@accounts');
    Route::get('/accounts/{id}', 'AccountsController@acc');
    Route::get('/accounts/region/{id}', 'AccountsController@accfromregion');

    Route::get('/regions', 'RegionsController@regions');
    Route::get('/region/{id}', 'RegionsController@getregion');
    Route::get('/availableregions', 'RegionsController@available_regions');

    Route::get('/reviews', 'ReviewsController@reviews');
    Route::get('/reviews/add/{tekst}/{author}/{stars}', 'ReviewsController@add_review');

    Route::get('/coupon', 'ApiController@coupons');

    Route::get('/verify/{orderid}', 'PaymentController@verify');

    Route::get('/getIP','ApiController@getIP');

    Route::get('/convert/{price}/{curr}/{curr_sec}', 'ApiController@covert');
    Route::get('/currency/', 'ApiController@getCurrency');
    Route::get('/country', 'ApiController@getCountryCode');
    Route::get('/pay_stripe', 'PaymentController@pay_stripe');
    Route::post('/pay_paypal', 'PaymentController@pay_paypal')->name('charge');
    Route::get('paymentsuccess', 'PaymentController@payment_success');
    Route::get('paymenterror', 'PaymentController@payment_error');
});

//Route::middleware('cors')->group(function () {
//    Route::get('/', 'HomeController@index');
//    Route::get('/accounts', 'ApiController@accounts');
//    Route::get('/accounts/{id}', 'ApiController@acc');
//    Route::get('/accounts/region/{id}', 'ApiController@accfromregion');
//
//    Route::get('/available/accounts/{id}', 'ApiController@getAccountsCount');
////    Route::get('/available/accounts/region/{id}', 'ApiController@available_accfromregion');
//
//    Route::get('/regions', 'ApiController@regions');
//    Route::get('/region/{id}', 'ApiController@getregion');
//    Route::get('/availableregions', 'ApiController@available_regions');
//
//    Route::get('/reviews', 'ApiController@reviews');
//    Route::post('/reviews/add', 'ApiController@add_review');
//
//    Route::get('/convert/{price}/{curr}/{curr_sec}', 'ApiController@covert');
//    Route::get('/currency', 'ApiController@getCurrency');
//    Route::get('/pay_stripe', 'PaymentController@pay_stripe');
//    Route::post('/pay_paypal', 'PaymentController@pay_paypal')->name('charge');
//    Route::get('paymentsuccess', 'PaymentController@payment_success');
//    Route::get('paymenterror', 'PaymentController@payment_error');
//});





