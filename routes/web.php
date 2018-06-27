<?php

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

Route::get('/settings', 'SettingsController@index');
Route::post('/amazonauth', 'SettingsController@store');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/orders', 'OrdersController@index');

Route::get('/report/{id}', 'ReportsController@create')->name('report');
// Route::get('/getReportRequestList', 'ReportsController@GetReportRequestList');
