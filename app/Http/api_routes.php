<?php

/**
* ---------
* Public Api
* ---------
**/
Route::group(['prefix' => 'api/public', 'middleware' => 'cors'], function(){
    Route::get('sponsors/{event_id}', function($event_id){
       return response()->json(\App\Models\Sponsor::active()->where('event_id', $event_id)->get());
    });
});


/**
* ---------
* Authenticated API
* ---------
**/
Route::group(['prefix' => 'api', 'middleware' => 'auth:api'], function () {

    /*
     * ---------------
     * Organisers
     * ---------------
     */


    /*
     * ---------------
     * Events
     * ---------------
     */
    Route::get('event/attendees', 'API\AppController@attendees');
    Route::get('event/attendee', 'API\AppController@attendee');

    Route::resource('events', 'API\EventsApiController');


    /*
     * ---------------
     * Attendees
     * ---------------
     */
    Route::resource('attendees', 'API\AttendeesApiController');


    /*
     * ---------------
     * Orders
     * ---------------
     */

    /*
     * ---------------
     * Users
     * ---------------
     */

    /*
     * ---------------
     * Check-In / Check-Out
     * ---------------
     */


    Route::get('/', function () {
        return response()->json([
            'Hello' => Auth::guard('api')->user()->full_name . '!'
        ]);
    });


});