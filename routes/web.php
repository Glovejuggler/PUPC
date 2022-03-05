<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FileController;
use App\Http\Middleware\AdminCheck;

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


Route::post('/create', 'App\Http\Controllers\UserController@create')->name('user.create');
Route::delete('delete/{user}', 'App\Http\Controllers\UserController@delete')->name('user.delete');

Route::post('/store', 'App\Http\Controllers\RoleController@store')->name('role.store');
Route::delete('destroy/{role}', 'App\Http\Controllers\RoleController@destroy')->name('role.destroy');

Route::post('/login/auth/check', 'App\Http\Controllers\MainController@loginCheck')->name('login.check');
Route::get('/logout', 'App\Http\Controllers\MainController@logout')->name('logout');

// files

Route::post('/uploadfile', 'App\Http\Controllers\FileController@fileUpload')->name('uploadfile');
Route::get('/file/{file}', 'App\Http\Controllers\FileController@view')->name('viewFile');
Route::delete('del/{file}', 'App\Http\Controllers\FileController@trash')->name('file.delete');

// show own profile
Route::get('/myProfile', 'App\Http\Controllers\UserController@myProfile')->name('view.myProfile');

// users
Route::get('/users/{user}', 'App\Http\Controllers\UserController@show')->name('user.show');
Route::get('/users/{user}/edit', 'App\Http\Controllers\UserController@edit')->name('user.edit');
Route::put('users/{user}', 'App\Http\Controllers\UserController@update')->name('user.update');

// me
Route::get('/editmyprofile', 'App\Http\Controllers\UserController@editmyprofile')->name('me.edit');
Route::put('/updateme', 'App\Http\Controllers\UserController@updateme')->name('me.update');
Route::get('/changepassword', 'App\Http\Controllers\UserController@changepass')->name('me.changepw');
Route::put('/udpatepass', 'App\Http\Controllers\UserController@updatepassword')->name('me.updatepw');

Route::group(['middleware'=>['UserCheck']], function(){
    Route::get('/', 'App\Http\Controllers\MainController@login')->name('login');
    Route::get('/dashboard', 'App\Http\Controllers\UserController@index')->name('user.index');
    Route::get('/users', 'App\Http\Controllers\UserController@users')->name('user.userslist')->middleware('AdminCheck');
    Route::get('/roles', 'App\Http\Controllers\RoleController@index')->name('role.roleslist')->middleware('AdminCheck');
    Route::get('/uploadfile', 'App\Http\Controllers\FileController@index')->name('file.upload');
});
