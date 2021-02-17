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

    'middleware' => ['cors'],

], function () {
    Route::get('/reviews/sum', 'ReviewsController@sum_review');
    Route::get('/reviewscookie/sum', 'ReviewsController@sum_reviewcookie');

    Route::get('/', 'HomeController@index');
    Route::post('/asd', 'HomeController@stripe');
    Route::get('/accounts', 'AccountsController@accounts');
    Route::get('/charge', 'ApiController@charge');
    Route::get('/accounts/{id}', 'AccountsController@acc');
    Route::get('/accounts/region/{id}', 'AccountsController@accfromregion');
    Route::get('/accounts/regionname/{name}', 'AccountsController@accfromregionname');

    Route::get('/regions', 'RegionsController@regions');
    Route::get('/region/{id}', 'RegionsController@getregion');
    Route::get('/availableregions', 'RegionsController@available_regions');


    Route::get('/reviews', 'ReviewsController@reviews');
    Route::get('/reviewscookie', 'ReviewsController@reviewscookie');
    Route::get('/reviews/{cookie}', 'ReviewsController@reviewsbycookie');
    Route::get('/reviewssum/{cookie}', 'ReviewsController@reviewssumbycookie');
    Route::get('/reviews/add/{tekst}/{author}/{stars}/{cookie}', 'ReviewsController@add_review');

    Route::get('/testAc', 'AccountsController@testAc');
    Route::get('/coupon', 'ApiController@coupons');
    Route::get('/koszyk/{dane}/{name}/{vat}/{email}/{localPrice}', 'ApiController@koszyk');
    Route::get('/checkVat/{country}', 'ApiController@checkVatRate');
    Route::get('/checkVat/{country}/{nip}', 'ApiController@checkVat');

    Route::get('/verify/{orderid}', 'PaymentController@verify');

    Route::get('/getIP','ApiController@getIP');

    Route::get('/convert/{price}/{curr}/{curr_sec}', 'ApiController@covert');
    Route::get('/currency', 'ApiController@getCurrency');
    Route::get('/country', 'ApiController@getCountryCode');
    Route::post('/pay_stripe', 'PaymentController@pay_stripe');
    Route::post('/pay_paypal', 'PaymentController@pay_paypal')->name('charge');
    Route::get('paymentsuccess', 'PaymentController@payment_success');
    Route::get('paymenterror', 'PaymentController@payment_error');

    Route::post('/checkout/pay_paypal', 'PaymentController@checkout_paypal');
    Route::post('/checkout/pay_stripe', 'PaymentController@checkout_stripe');


});

Auth::routes();

