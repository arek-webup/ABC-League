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

Route::get('/', 'FrontController@index');

Route::get('/pay_stripe', 'PaymentController@pay_stripe');
Route::post('/pay_paypal', 'PaymentController@pay_paypal')->name('charge');
Route::get('paymentsuccess', 'PaymentController@payment_success');
Route::get('paymenterror', 'PaymentController@payment_error');

Auth::routes();

