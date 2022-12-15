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

Route::get('/arena', 'ArenaController@index');
Route::get('/index','ArenaController@index');
Route::get('/','ArenaController@index');

Route::get('/admin', 'AdminController@index');

Route::get('/login', 'LoginController@index');
Route::post('login', 'LoginController@login')->name('login');
Route::get('/logout', 'LoginController@logout');


Route::get('/reservation/{game}', 'ReservationController@index');
Route::post('/reserve', 'ReservationController@reserve');

Route::get('/register', 'RegisterController@index');
Route::post('/register', 'RegisterController@register');


Route::get('/verifyemail', 'VerifyEmailController@index');
Route::post('/verifyemail', 'VerifyEmailController@verify');

Route::get('/resendotp', 'VerifyEmailController@resendotp');

Route::get('/forgotpassword', 'ForgotPasswordController@index');
Route::post('/sendotp', 'ForgotPasswordController@sendotp');

Route::get('/admin', 'AdminController@index');
