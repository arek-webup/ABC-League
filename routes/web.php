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

Route::group([

    'middleware' => ['api'],
    'prefix' => 'auth'

], function () {

    Route::get('/', 'HomeController@index');
    Route::get('/accounts', 'ApiController@accounts');
    Route::get('/accounts/{id}', 'ApiController@acc');
    Route::get('/accounts/region/{id}', 'ApiController@accfromregion');

    Route::get('/available/accounts/{id}', 'ApiController@getAccountsCount');
//    Route::get('/available/accounts/region/{id}', 'ApiController@available_accfromregion');

    Route::get('/regions', 'ApiController@regions');
    Route::get('/region/{id}', 'ApiController@getregion');
    Route::get('/availableregions', 'ApiController@available_regions');

    Route::get('/reviews', 'ApiController@reviews');
    Route::post('/reviews/add', 'ApiController@add_review');

    Route::get('/convert/{price}/{curr}/{curr_sec}', 'ApiController@covert');
    Route::get('/currency', 'ApiController@getCurrency');
    Route::get('/pay_stripe', 'PaymentController@pay_stripe');
    Route::post('/pay_paypal', 'PaymentController@pay_paypal')->name('charge');
    Route::get('paymentsuccess', 'PaymentController@payment_success');
    Route::get('paymenterror', 'PaymentController@payment_error');
});

Auth::routes();

