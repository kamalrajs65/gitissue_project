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

Route::view('/','auth.login');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('login/{provider}', 'App\Http\Controllers\Auth\LoginController@redirectToProvider');
Route::get('{provider}/callback', 'App\Http\Controllers\Auth\LoginController@handleProviderCallback');
Route::get('signout', '\App\Http\Controllers\Auth\LoginController@signout');



Route::group(['middleware' => ['auth']], function () {
    Route::get('gitform','App\Http\Controllers\Githubcontroller@index');
    Route::get('list','App\Http\Controllers\Githubcontroller@list');
    Route::get('issue-list/{id}','App\Http\Controllers\Githubcontroller@IssueList');
    Route::post('get_git_data','App\Http\Controllers\Githubcontroller@GetGitData'); 
});


