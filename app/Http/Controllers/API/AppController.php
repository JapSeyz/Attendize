<?php

namespace app\Http\Controllers\API;

use App\Models\Attendee;
use Carbon\Carbon;
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

        $attendee->save();

        $message = 'Brugeren er nu tjekket ind';
        if(! $request->has_arrived){
            $message = 'Brugeren er nu tjekket ud';
        }

        return response()->json([
            'title' => $message,
            'body' => $attendee->fullName,
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    public function checkIn(Request $request)
    {
        $attendee = Attendee::where('event_id', env('CURRENT_EVENT'))->where('private_reference_number', $request->code)->first();

        if(!$attendee){
            return response()->json([
                'title' => 'Ukendt Kode',
                'body' => 'Billetten tilhører ikke Musikliv',
            ], 400);
        }

        if($attendee->has_arrived){
            $arrivalTime = Carbon::parse($attendee->arrival_time)->format('H:i - d/m');

            return response()->json([
                'title' => 'Allerede tjekket ind',
                'body' => $arrivalTime,
            ], 400);
        }

        $attendee->has_arrived = 1;
        $attendee->arrival_time = Carbon::now()->format('Y-m-d H:i:s');

        $attendee->save();

        return response()->json([
            'title' => 'Brugeren er nu tjekket ind',
            'body' => $attendee->fullName,
            'id' => $attendee->id,
        ]);
    }
}