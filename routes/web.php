<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/threads', 'ThreadsController@index')->name('all_threads');
Route::get('/threads/create', 'ThreadsController@create')->name('create_thread');
Route::post('/threads', 'ThreadsController@store')->name('store_thread');
Route::get('/threads/{channel}', 'ThreadsController@index')->name('show_channel');
Route::get('/threads/{channel:slug}/{thread}', 'ThreadsController@show')->name('show_thread');
Route::post('/threads/{channel:slug}/{thread}/replies', 'RepliesController@store')->name('add_reply_to_thread');