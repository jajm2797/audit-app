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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::get('upgrade', function () {return view('pages.upgrade');})->name('upgrade');
	 Route::get('map', function () {return view('pages.maps');})->name('map');
	 Route::get('icons', function () {return view('pages.icons');})->name('icons');
	 Route::get('table-list', function () {return view('pages.tables');})->name('table');
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

/**
 * RUTAS PARA AUDITORIAS
 */

Route::get('/audits', 'App\Http\Controllers\AuditController@index')->name('audits');
Route::post('/audits/create', 'App\Http\Controllers\AuditController@create')->name('create.audits');
Route::post('/audits/edit', 'App\Http\Controllers\AuditController@edit')->name('edit.audits');
Route::any('/audits/delete/{id}', 'App\Http\Controllers\AuditController@destroy')->name('delete.audits');

/**
 * RUTAS PARA HALLAZGOS
 */

Route::get('/finds', 'App\Http\Controllers\FindController@index')->name('finds');
Route::post('/finds/create', 'App\Http\Controllers\FindController@create')->name('create.finds');
Route::post('/finds/edit', 'App\Http\Controllers\FindController@edit')->name('edit.finds');
Route::any('/finds/delete/{id}', 'App\Http\Controllers\FindController@destroy')->name('delete.finds');

