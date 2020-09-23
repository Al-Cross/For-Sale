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

Route::get('/', 'AdsController@index');

Auth::routes();

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});


Route::group(['middleware' => 'auth', 'prefix' => 'myaccount'], function () {
    Route::get('/', 'UsersController@index')->name('profile');
    Route::get('/create', 'AdsController@create')->name('new_ad')->middleware('must-be-confirmed');
    Route::post('/postad', 'AdsController@store')->name('create_ad')->middleware('must-be-confirmed');
    Route::get('/messages', 'MessagesController@index')->name('messages');
    Route::post('/messages/send', 'MessagesController@store')->name('send')->middleware('must-be-confirmed');
    Route::post('/messages/{message}/archive', 'ArchiveController@store')->name('archive');
    Route::delete('/messages/{message}/delete-received', 'MessagesController@destroyReceived')->name('delete-from-inbox');
    Route::delete('/messages/{message}/delete-sent', 'MessagesController@destroySent')->name('delete-from-sent');
    Route::delete('/messages/{message}/delete-archived', 'ArchiveController@destroy')->name('delete-from-archived');
});

Route::get('/search', 'AdsController@search');
Route::get('/register/confirm', 'Api\RegisterConfirmationController@index');
Route::get('/getlocation', 'AdsController@findLocation');
Route::get('/{category:slug}/{section:slug}', 'SectionsController@index')->name('section');
Route::get('/{category:slug}/{section:slug}/{ad:slug}', 'AdsController@show');
