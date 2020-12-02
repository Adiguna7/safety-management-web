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
Route::post('/survey/submit', 'UserController@submit')->middleware('auth', 'user');

// user route
Route::get('/user/dashboard', 'UserController@dashboard')->middleware('auth', 'user');
Route::get('/survey/hasil/personal', 'UserController@hasilPersonal')->middleware('auth', 'user');
Route::get('/survey/hasil/getpersonal', 'UserController@getHasilPersonal')->middleware('auth', 'user');
Route::get('/survey/hasil/institusi', 'UserController@hasilInstitusi')->middleware('auth', 'user');
Route::get('/survey/hasil/getinstitusi', 'UserController@getHasilInstitusi')->middleware('auth', 'user');

Route::get('/survey/solusi', 'UserController@solusi')->middleware('auth', 'user');
Route::post('/survey/solusi/save', 'UserController@solusiSave')->middleware('auth', 'user');


// ROUTE ADMIN
Route::get('/admin/dashboard', 'AdminController@index')->middleware('auth', 'admin');
Route::get('/admin/hasil/institusi', 'AdminController@indexInstitusi')->middleware('auth', 'admin');
Route::get('/admin/hasil/institusi/{institution_id}', 'AdminController@institusiById')->middleware('auth', 'admin');
Route::get('/admin/hasil/getinstitusi/{institution_id}', 'AdminController@getInstitusi')->middleware('auth', 'admin');

Route::get('/admin/hasil/personal', 'AdminController@indexPersonal')->middleware('auth', 'admin');
Route::get('/admin/hasil/personal/{user_id}', 'AdminController@personalById')->middleware('auth', 'admin');
Route::get('/admin/hasil/getpersonal/{user_id}', 'AdminController@getPersonal')->middleware('auth', 'admin');

Route::get('/admin/solusi', 'AdminController@indexSolusi')->middleware('auth', 'admin');
Route::post('/admin/solusi/create', 'AdminController@createSolusi')->middleware('auth', 'admin');
Route::post('/admin/solusi/update', 'AdminController@createSolusi')->middleware('auth', 'admin');
Route::post('/admin/solusi/delete', 'AdminController@deleteSolusi')->middleware('auth', 'admin');

Route::get('/admin/question', 'AdminController@indexQuestion')->middleware('auth', 'admin');
Route::post('/admin/question/create', 'AdminController@createQuestion')->middleware('auth', 'admin');
Route::post('/admin/question/update', 'AdminController@updateQuestion')->middleware('auth', 'admin');
Route::post('/admin/question/delete', 'AdminController@deleteQuestion')->middleware('auth', 'admin');

Route::get('/admin/institution', 'AdminController@indexInstitution')->middleware('auth', 'admin');
Route::post('/admin/institution/create', 'AdminController@createInstitution')->middleware('auth', 'admin');
Route::post('/admin/institution/update', 'AdminController@updateInstitution')->middleware('auth', 'admin');
Route::post('/admin/institution/delete', 'AdminController@deleteInstitution')->middleware('auth', 'admin');

Route::get('/admin/users', 'AdminController@indexUsers')->middleware('auth', 'admin');
Route::post('/admin/users/updateadmin', 'AdminController@updateAdmin')->middleware('auth', 'admin');



