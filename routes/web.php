<?php

use Illuminate\Support\Facades\Artisan;
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

Route::get('/forgot-password', 'ForgotPasswordController@index');
Route::post('/forgot-password', 'ForgotPasswordController@sendPasswordResetEmail');
Route::get('/forgot-password/{token}', 'ForgotPasswordController@getResetPasswordPage');
Route::post('/reset-password', 'ForgotPasswordController@resetPassword');

Route::get('/admin/', 'AdminController@index');
Route::post('/admin/removeReservation', 'AdminController@removeReservation');
Route::get('/admin/settings', 'SettingsController@index');
Route::post('/admin/settings/update', 'SettingsController@update');

Route::get('/changepassword', 'ChangePasswordController@index');
Route::post('/changepassword', 'ChangePasswordController@changePassword');

Route::get('/myreservations', 'MyReservationsController@index');
Route::post('/myreservations/cancel', 'MyReservationsController@cancel');

Route::post('/admin/removeReservation/all', 'AdminController@removeAllReservations');
