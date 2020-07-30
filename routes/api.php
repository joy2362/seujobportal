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

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@me');
    Route::post('teacher/signup', 'AuthController@teacherreg');
    Route::post('alumni/signup', 'AuthController@alumnireg');
    Route::post('student/signup', 'AuthController@studentreg');
    Route::post('forget', 'AuthController@forget');

});
Route::get('email/verify/{id}', 'VerificationController@verify')->name('verification.verify');
Route::post('email/resend', 'VerificationController@resend')->name('verification.resend');

Route::group([

    'middleware' => 'api',
    'prefix' => 'password'

], function () {

    Route::post('create', 'PasswordResetController@create');
    Route::get('find/{token}', 'PasswordResetController@find');
    Route::post('reset', 'PasswordResetController@reset');

});
Route::group([

    'middleware' => 'api',
    'prefix' => 'admin'

], function ($router) {

    Route::post('verify', 'Admin\AdminController@verify');
    Route::post('category/add', 'jobHandler\CategoryController@store');
    Route::post('category/update', 'jobHandler\CategoryController@update');
    Route::get('category/index', 'jobHandler\CategoryController@index');
    Route::get('category/destroy/{id}', 'jobHandler\CategoryController@destroy');

});
