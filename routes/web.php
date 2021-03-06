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
    Route::get('/upgrade', 'AddAdsController@index')->middleware('must-be-confirmed');
    Route::post('/postad', 'AdsController@store')->name('create_ad')->middleware('must-be-confirmed');
    Route::get('/messages', 'MessagesController@index')->name('messages');
    Route::get('/notifications', 'NotificationsController@show');
    Route::get('/settings', 'UsersController@edit');
    Route::get('/{ad:slug}/edit', 'AdsController@edit')->name('edit_ad');
    Route::get('/wallet/load-account', 'PaymentsController@index');
    Route::get('/wallet/advanced', 'AddAdsController@advanced')->name('advanced_upgrade');
    Route::get('/wallet/premium', 'AddAdsController@premium')->name('premium_upgrade');
    Route::post('/wallet/complete-payment', 'PaymentsController@create')->name('process_payment');
    Route::get('/settings/email-sent', 'EmailConfirmationsController@index');
    Route::get('/settings/{user}/delete', 'UsersController@destroy')->name('profile_deletion');
    Route::patch('/settings/pass', 'UsersController@updatePassword');
    Route::patch('/settings/update', 'UsersController@update')->name('profile_update');
    Route::patch('/settings/notifications', 'NotificationsController@update');
    Route::patch('/{ad}/update', 'AdsController@update')->name('update_ad');
    Route::patch('/{ad}/archive', 'ArchiveController@archiveAd')->name('archive-ad');
    Route::patch('/{ad}/activate', 'ArchiveController@activateAd')->name('activate-ad');
    Route::patch('/{ad}/extend', 'ArchiveController@extend')->name('extend-ad');
    Route::patch('/{ad}/promote', 'FeaturedAdsController@index')->name('promote');
    Route::post('/settings/{user}/logos', 'ImageUploadsController@store')->middleware('must-be-confirmed');
    Route::post('/messages/send', 'MessagesController@store')->name('send')->middleware(['must-be-confirmed', 'honeypot']);
    Route::post('/messages/{message}/archive', 'ArchiveController@archiveMessage')->name('archive');
    Route::post('/wallet/fill', 'PaymentsController@store')->name('add_to_balance');
    Route::post('/settings/deletion-email', 'EmailConfirmationsController@destroy')->name('deletion_email');
    Route::delete('/{ad}/delete', 'AdsController@destroy')->name('delete_ad');
    Route::delete('/messages/{message}/delete-received', 'MessagesController@destroyReceived')->name('delete-from-inbox');
    Route::delete('/messages/{message}/delete-sent', 'MessagesController@destroySent')->name('delete-from-sent');
    Route::delete('/messages/{message}/delete-archived', 'ArchiveController@destroyMessage')->name('delete-from-archived');
    Route::delete('/mark-all', 'NotificationsController@destroyAll');
    Route::delete('/{notification}', 'NotificationsController@destroy')->name('destroy-notif');
    Route::delete('/settings/{user}/logos/delete', 'ImageUploadsController@destroy')->middleware('must-be-confirmed');
    Route::delete('/images/{image}/delete', 'ImageUploadsController@deleteAdImage')->name('delete_ad_image');
});

Route::get('/search', 'AdsController@search');
Route::get('/observed', 'ObservedAdsController@index');
Route::post('/favourite', 'ObservedAdsController@store');
Route::delete('/unfavourite', 'ObservedAdsController@destroy');
Route::get('/register/confirm', 'Api\RegisterConfirmationController@index');
Route::get('/getlocation', 'AdsController@findLocation');
Route::get('/user-ads/{user:name}', 'UsersController@show')->name('user_ads');
Route::get('/{category:slug}', 'SectionsController@index');
Route::get('/{category:slug}/{section:slug}', 'SectionsController@show')->name('section');
Route::get('/{category:slug}/{section:slug}/{ad:slug}', 'AdsController@show')->name('show_ad');
