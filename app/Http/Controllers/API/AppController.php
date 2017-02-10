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
}