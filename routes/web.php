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

Route::get('/', 'IndexController');
Route::get('/league/generate', 'LeagueController@generate');
Route::get('/team/generate',  'TeamController@generate');
Route::post('/division/generate', 'DivisionController@generate');
Route::post('/score/division', 'ScoreController@division');
Route::post('/score/finals', 'ScoreController@finals');
