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
    Route::get('event/tickets', 'API\AppController@tickets');
    Route::post('event/attendee', 'API\AppController@attendee');
    Route::post('event/checkin', 'API\AppController@checkIn');
    Route::post('event/purchase', 'API\AppController@purchase');
    Route::post('event/cancel_purchase', 'API\AppController@cancelPurchase');

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