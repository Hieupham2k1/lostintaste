<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Post;

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


Auth::routes();

Route::get('/', 'Controller@aboutMe');

//LostinTaste Module
Route::prefix('lostintaste')->name('lostintaste.')->group(function() {
    
    // welcome's route
    Route::get('/', 'LostinTaste\HomeController@index')->name('welcome');
    Route::get('searcher', 'LostinTaste\HomeController@search')->name('searcher');
    Route::get('getprovince/{district}', 'LostinTaste\HomeController@getProvince');
    Route::get('getfood', 'LostinTaste\HomeController@getFood');

    // user's routes
    Route::get('me', 'LostinTaste\HomeController@selfInfo')->name('self_info');
    Route::get('profile/{id}', 'LostinTaste\HomeController@userProfile')->name('profile');
    Route::get('update/user/{id}', 'LostinTaste\HomeController@updateUser')->name('update_user');
    Route::post('update/user', 'LostinTaste\HomeController@insertUser')->name('insert_user');

    // news's routes
    Route::get('news', 'LostinTaste\HomeController@news')->name('news');
    Route::get('attend/{id}', 'LostinTaste\HomeController@attend');

    // post's routes
    Route::get('post', 'LostinTaste\HomeController@post')->name('post');
    Route::get('newpost', 'LostinTaste\HomeController@newPost')->name('new_post');
    Route::get('update/post/{id}', 'LostinTaste\HomeController@updatePost');
    Route::post('insertpost', 'LostinTaste\HomeController@insertPost')->name('insert_post');
    Route::get('delete/post/{id}', 'LostinTaste\HomeController@deletePost');

    // savedpost's routes
    Route::get('savedpost', 'LostinTaste\HomeController@savedpost')->name('savedpost');
    Route::get('newsavedpost/{id}', 'LostinTaste\HomeController@newSavedpost');
    Route::get('update/savedpost/{id}/{mode}', 'LostinTaste\HomeController@updateSavedpost');
    Route::get('delete/savedpost/{id}', 'LostinTaste\HomeController@deleteSavedpost');

    // schedule's routes
    Route::get('schedule', 'LostinTaste\HomeController@schedule')->name('schedule');
    Route::get('newschedule/{id}', 'LostinTaste\HomeController@newSchedule');
    Route::get('update/schedule/{id}', 'LostinTaste\HomeController@updateSchedule');
    Route::post('insertschedule', 'LostinTaste\HomeController@insertSchedule')->name('insert_schedule');
    Route::get('delete/schedule/{id}', 'LostinTaste\HomeController@deleteSchedule');

    Route::get('delete/attendee/{id}', 'LostinTaste\HomeController@deleteAttendee')->name('delete_attendee');

    // friend's routes
    Route::get('friend', 'LostinTaste\HomeController@friend')->name('friend');
    Route::get('search-friend/{input?}', 'LostinTaste\HomeController@searchFriend')->name('search_friend');
    Route::get('addfriend/{id}', 'LostinTaste\HomeController@addfriend')->name('add_friend');
    Route::get('dropfriend/{id}', 'LostinTaste\HomeController@dropfriend')->name('drop_friend');

    // message's routes
    Route::get('message', 'LostinTaste\HomeController@message')->name('message');
    Route::get('inbox/{id?}', 'LostinTaste\HomeController@inbox')->name('inbox');
    Route::get('sendmessage', 'LostinTaste\HomeController@sendMessage')->name('send_message');
    Route::get('refresh/{id}', 'LostinTaste\HomeController@refresh')->name('refresh');

});










