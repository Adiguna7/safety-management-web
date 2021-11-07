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
Route::get('/survey/hasil/institusi', 'UserController@hasilInstitusi')->middleware('auth', 'userperusahaan');
Route::get('/survey/hasil/getinstitusi', 'UserController@getHasilInstitusi')->middleware('auth', 'userperusahaan');

Route::get('/survey/solusi', 'UserController@solusi')->middleware('auth', 'user');
Route::post('/survey/solusi/save', 'UserController@solusiSave')->middleware('auth', 'user');


// ROUTE SUPER-ADMIN
Route::get('/super-admin/dashboard', 'AdminController@index')->middleware('auth', 'admin');
Route::get('/super-admin/hasil/institusi', 'AdminController@indexInstitusi')->middleware('auth', 'admin');
Route::get('/super-admin/hasil/institusi/{institution_id}', 'AdminController@institusiById')->middleware('auth', 'admin');
Route::get('/super-admin/hasil/getinstitusi/{institution_id}', 'AdminController@getInstitusi')->middleware('auth', 'admin');

Route::get('/super-admin/hasil/personal', 'AdminController@indexPersonal')->middleware('auth', 'admin');
Route::get('/super-admin/hasil/personal/{user_id}', 'AdminController@personalById')->middleware('auth', 'admin');
Route::get('/super-admin/hasil/getpersonal/{user_id}', 'AdminController@getPersonal')->middleware('auth', 'admin');

Route::get('/super-admin/solusi', 'AdminController@indexSolusi')->middleware('auth', 'superadmin');
Route::post('/super-admin/solusi/create', 'AdminController@createSolusi')->middleware('auth', 'superadmin');
Route::post('/super-admin/solusi/update', 'AdminController@updateSolusi')->middleware('auth', 'superadmin');
Route::post('/super-admin/solusi/delete', 'AdminController@deleteSolusi')->middleware('auth', 'superadmin');

Route::get('/super-admin/question', 'AdminController@indexQuestion')->middleware('auth', 'superadmin');
Route::post('/super-admin/question/create', 'AdminController@createQuestion')->middleware('auth', 'superadmin');
Route::post('/super-admin/question/update', 'AdminController@updateQuestion')->middleware('auth', 'superadmin');
Route::post('/super-admin/question/delete', 'AdminController@deleteQuestion')->middleware('auth', 'superadmin');

Route::get('/super-admin/institution', 'AdminController@indexInstitution')->middleware('auth', 'superadmin');
Route::post('/super-admin/institution/create', 'AdminController@createInstitution')->middleware('auth', 'superadmin');
Route::post('/super-admin/institution/update', 'AdminController@updateInstitution')->middleware('auth', 'superadmin');
Route::post('/super-admin/institution/delete', 'AdminController@deleteInstitution')->middleware('auth', 'superadmin');

Route::get('/super-admin/users', 'AdminController@indexUsers')->middleware('auth', 'admin');
Route::post('/super-admin/users/updateadmin', 'AdminController@updateAdmin')->middleware('auth', 'admin');
Route::post('/super-admin/users/updateinstitution', 'AdminController@updateUserInstitution')->middleware('auth', 'admin');


Route::get('/super-admin/category-question', 'AdminController@indexCategoryQuestion')->middleware('auth', 'superadmin');
Route::post('/super-admin/category-question/create', 'AdminController@createCategoryQuestion')->middleware('auth', 'superadmin');
Route::post('/super-admin/category-question/update', 'AdminController@updateCategoryQuestion')->middleware('auth', 'superadmin');
Route::post('/super-admin/category-question/delete', 'AdminController@deleteCategoryQuestion')->middleware('auth', 'superadmin');


Route::get('/super-admin/question-group', 'AdminController@indexQuestionGroup')->middleware('auth', 'admin');
Route::get('/super-admin/question-group/{institution_id}', 'AdminController@indexQuestionGroupById')->middleware('auth', 'admin');
Route::post('/super-admin/question-group/create', 'AdminController@createQuestionGroup')->middleware('auth', 'admin');
Route::post('/super-admin/question-group/update', 'AdminController@updateQuestionGroup')->middleware('auth', 'admin');
Route::post('/super-admin/question-group/delete', 'AdminController@deleteQuestionGroup')->middleware('auth', 'admin');

Route::get('/super-admin/question-group/import/{institution_id}', 'AdminController@importQuestionGroup')->middleware('auth', 'admin');
Route::get('/super-admin/question-group/import/getallsurveyquestion', 'AdminController@getAllSurveyQuestionQuestionGroup')->middleware('auth', 'admin');
Route::post('/super-admin/question-group/import/save', 'AdminController@importSaveQuestionGroup')->middleware('auth', 'admin');
Route::post('/super-admin/question-group/import/cancel', 'AdminController@importCancelQuestionGroup')->middleware('auth', 'admin');

Route::post('/super-admin/question-group/create', 'AdminController@createQuestionGroup')->middleware('auth', 'admin');
Route::post('/super-admin/question-group/update', 'AdminController@updateQuestionGroup')->middleware('auth', 'admin');
Route::post('/super-admin/question-group/delete', 'AdminController@deleteQuestionGroup')->middleware('auth', 'admin');

Route::get('/super-admin/pembobotan', 'AdminController@indexPembobotan')->middleware('auth', 'admin');
Route::post('/super-admin/pembobotan/create', 'AdminController@createPembobotan')->middleware('auth', 'admin');
Route::post('/super-admin/pembobotan/update', 'AdminController@updatePembobotan')->middleware('auth', 'admin');
Route::post('/super-admin/pembobotan/delete', 'AdminController@deletePembobotan')->middleware('auth', 'admin');

// ROUTE ADMIN PERUSAHAAN
// Route::get('/admin/dashboard', 'AdminController@indexAdminPerusahaan')->middleware('auth', 'admin');
// Route::get('/super-admin/hasil/institusi', 'AdminController@indexInstitusi')->middleware('auth', 'superadmin');
// Route::get('/super-admin/hasil/institusi/{institution_id}', 'AdminController@institusiById')->middleware('auth', 'superadmin');
// Route::get('/super-admin/hasil/getinstitusi/{institution_id}', 'AdminController@getInstitusi')->middleware('auth', 'superadmin');

