<?php

namespace app\Http\Controllers\API;

use App\Models\Attendee;
use Illuminate\Http\Request;

class AppController extends ApiBaseController
{

    /**
     * @param Request $request
     * @return mixed
     */
    public function attendees(Request $request)
    {
        return Attendee::scope($this->account_id)->where('event_id', env('CURRENT_EVENT'))->get();
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    public function attendee(Request $request)
    {
        $attendee = Attendee::where('event_id', env('CURRENT_EVENT'))->where('id', $request->attendee_id)->first();

        $attendee->has_arrived = $request->has_arrived;
        $attendee->arrival_time = $request->arrival_time;

        return response()->json([
            'message' => 'Brugeren er opdateret'
        ]);
    }
}