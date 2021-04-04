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

Route::prefix('lostintaste')->name('lostintaste.')->group(function() {
    Auth::routes();
    
    // welcome's route
    Route::get('/', 'HomeController@index')->name('welcome');
    Route::get('searcher', 'HomeController@search')->name('searcher');
    Route::get('getprovince/{district}', 'HomeController@getProvince');
    Route::get('getfood', 'HomeController@getFood');

    // user's routes
    Route::get('me', 'HomeController@selfInfo')->name('self_info');
    Route::get('profile/{id}', 'HomeController@userProfile')->name('profile');
    Route::get('update/user/{id}', 'HomeController@updateUser')->name('update_user');
    Route::post('update/user', 'HomeController@insertUser')->name('insert_user');

    // news's routes
    Route::get('news', 'HomeController@news')->name('news');
    Route::get('attend/{id}', 'HomeController@attend');

    // post's routes
    Route::get('post', 'HomeController@post')->name('post');
    Route::get('newpost', 'HomeController@newPost')->name('new_post');
    Route::get('update/post/{id}', 'HomeController@updatePost');
    Route::post('insertpost', 'HomeController@insertPost')->name('insert_post');
    Route::get('delete/post/{id}', 'HomeController@deletePost');

    // savedpost's routes
    Route::get('savedpost', 'HomeController@savedpost')->name('savedpost');
    Route::get('newsavedpost/{id}', 'HomeController@newSavedpost');
    Route::get('update/savedpost/{id}/{mode}', 'HomeController@updateSavedpost');
    Route::get('delete/savedpost/{id}', 'HomeController@deleteSavedpost');

    // schedule's routes
    Route::get('schedule', 'HomeController@schedule')->name('schedule');
    Route::get('newschedule/{id}', 'HomeController@newSchedule');
    Route::get('update/schedule/{id}', 'HomeController@updateSchedule');
    Route::post('insertschedule', 'HomeController@insertSchedule')->name('insert_schedule');
    Route::get('delete/schedule/{id}', 'HomeController@deleteSchedule');

    Route::get('delete/attendee/{id}', 'HomeController@deleteAttendee')->name('delete_attendee');

    // friend's routes
    Route::get('friend', 'HomeController@friend')->name('friend');
    Route::get('search-friend/{input?}', 'HomeController@searchFriend')->name('search_friend');
    Route::get('addfriend/{id}', 'HomeController@addfriend')->name('add_friend');
    Route::get('dropfriend/{id}', 'HomeController@dropfriend')->name('drop_friend');

    // message's routes
    Route::get('message', 'HomeController@message')->name('message');
    Route::get('inbox/{id?}', 'HomeController@inbox')->name('inbox');
    Route::get('sendmessage', 'HomeController@sendMessage')->name('send_message');
    Route::get('refresh/{id}', 'HomeController@refresh')->name('refresh');

});
