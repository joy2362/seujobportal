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
    Route::post('admin/signup', 'Admin\AdminController@adminreg');
    Route::post('forget', 'AuthController@forget');
    Route::post('check/email', 'AuthController@verify');

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

    Route::post('category/add', 'Admin\category\CategoryController@store');
    Route::post('category/update', 'Admin\category\CategoryController@update');
    Route::get('category/index', 'Admin\category\CategoryController@index');
    Route::get('category/destroy/{id}', 'Admin\category\CategoryController@destroy');
    Route::get('student/destroy/{id}', 'Admin\AdminController@studentDestroy');
    Route::get('alumni/destroy/{id}', 'Admin\AdminController@alumniDestroy');
    Route::get('faculty/destroy/{id}', 'Admin\AdminController@facultyDestroy');

    Route::post('job/add', 'Admin\job\Jobcontroller@store');
    Route::get('job/index', 'Admin\job\Jobcontroller@index');
    Route::get('job/destroy/{id}', 'Admin\job\Jobcontroller@destroy');
    Route::get('job/fatch/{id}', 'Admin\job\Jobcontroller@fatch');
    Route::get('job/show/{id}', 'Admin\job\Jobcontroller@show');
    Route::post('job/update/{id}', 'Admin\job\Jobcontroller@update');

    Route::get('event/destroy/{id}', 'Admin\event\EventController@destroy');
    Route::post('event/update/{id}', 'Admin\event\EventController@update');
    Route::get('event/show/{id}', 'Admin\event\EventController@show');
    Route::get('event/index', 'Admin\event\EventController@index');
    Route::post('event/add', 'Admin\event\EventController@store');

    Route::post('all', 'Admin\AdminController@allAdmin');
    Route::get('home/all', 'Admin\AdminController@adminHome');
    Route::get('remove/{id}', 'Admin\AdminController@destroy');
    Route::get('info/{id}', 'Admin\AdminController@info');
    Route::post('profile/image/{id}', 'Admin\adminProfile@imageChange');
    Route::post('setting/name/{id}', 'Admin\adminProfile@namechange');
    Route::post('setting/password/{id}', 'Admin\adminProfile@passwordchange');
    Route::post('setting/validation/{id}', 'Admin\adminProfile@validationchange');

});
