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

// Route::get('error', function () {
//     return view('errors.deletedaccount');
// });

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


// ROUTE SUPER-ADMIN
Route::get('/super-admin/dashboard', 'AdminController@index')->middleware('auth', 'superadmin');
Route::get('/super-admin/hasil/institusi', 'AdminController@indexInstitusi')->middleware('auth', 'superadmin');
Route::get('/super-admin/hasil/institusi/{institution_id}', 'AdminController@institusiById')->middleware('auth', 'superadmin');
Route::get('/super-admin/hasil/getinstitusi/{institution_id}', 'AdminController@getInstitusi')->middleware('auth', 'superadmin');

Route::get('/super-admin/hasil/personal', 'AdminController@indexPersonal')->middleware('auth', 'superadmin');
Route::get('/super-admin/hasil/personal/{user_id}', 'AdminController@personalById')->middleware('auth', 'superadmin');
Route::get('/super-admin/hasil/getpersonal/{user_id}', 'AdminController@getPersonal')->middleware('auth', 'superadmin');

Route::get('/super-admin/solusi', 'AdminController@indexSolusi')->middleware('auth', 'superadmin');
Route::post('/super-admin/solusi/create', 'AdminController@createSolusi')->middleware('auth', 'superadmin');
Route::post('/super-admin/solusi/update', 'AdminController@createSolusi')->middleware('auth', 'superadmin');
Route::post('/super-admin/solusi/delete', 'AdminController@deleteSolusi')->middleware('auth', 'superadmin');

Route::get('/super-admin/question', 'AdminController@indexQuestion')->middleware('auth', 'superadmin');
Route::post('/super-admin/question/create', 'AdminController@createQuestion')->middleware('auth', 'superadmin');
Route::post('/super-admin/question/update', 'AdminController@updateQuestion')->middleware('auth', 'superadmin');
Route::post('/super-admin/question/delete', 'AdminController@deleteQuestion')->middleware('auth', 'superadmin');

Route::get('/super-admin/institution', 'AdminController@indexInstitution')->middleware('auth', 'superadmin');
Route::post('/super-admin/institution/create', 'AdminController@createInstitution')->middleware('auth', 'superadmin');
Route::post('/super-admin/institution/update', 'AdminController@updateInstitution')->middleware('auth', 'superadmin');
Route::post('/super-admin/institution/delete', 'AdminController@deleteInstitution')->middleware('auth', 'superadmin');

Route::get('/super-admin/users', 'AdminController@indexUsers')->middleware('auth', 'superadmin');
Route::post('/super-admin/users/updateadmin', 'AdminController@updateAdmin')->middleware('auth', 'superadmin');


Route::get('/super-admin/category-question', 'AdminController@indexCategoryQuestion')->middleware('auth', 'superadmin');
Route::post('/super-admin/category-question/create', 'AdminController@createCategoryQuestion')->middleware('auth', 'superadmin');
Route::post('/super-admin/category-question/update', 'AdminController@updateCategoryQuestion')->middleware('auth', 'superadmin');
Route::post('/super-admin/category-question/delete', 'AdminController@deleteCategoryQuestion')->middleware('auth', 'superadmin');



