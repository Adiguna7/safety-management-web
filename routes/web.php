<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
Route::get('/user/survey', 'UserController@index')->middleware('auth');
Route::post('/survey/submit', 'UserController@submit')->middleware('auth');

// user route
Route::get('/user/dashboard', 'UserController@dashboard');
Route::get('/survey/hasil/personal', 'UserController@hasilPersonal');
Route::get('/survey/hasil/getpersonal', 'UserController@getHasilPersonal');
Route::get('/survey/hasil/institusi', 'UserController@hasilInstitusi');
Route::get('/survey/hasil/getinstitusi', 'UserController@getHasilInstitusi');

Route::get('/survey/solusi', 'UserController@solusi');
Route::post('/survey/solusi/save', 'UserController@solusiSave');

Route::get('/admin/dashboard', 'AdminController@index')->middleware('auth');
Route::get('/admin/hasil/institusi', 'AdminController@indexInstitusi')->middleware('auth');
Route::get('/admin/hasil/institusi/{institution_id}', 'AdminController@institusiById')->middleware('auth');
Route::get('/admin/hasil/getinstitusi/{institution_id}', 'AdminController@getInstitusi')->middleware('auth');

Route::get('/admin/hasil/personal', 'AdminController@indexPersonal')->middleware('auth');
Route::get('/admin/hasil/personal/{user_id}', 'AdminController@personalById')->middleware('auth');
Route::get('/admin/hasil/getpersonal/{user_id}', 'AdminController@getPersonal')->middleware('auth');



