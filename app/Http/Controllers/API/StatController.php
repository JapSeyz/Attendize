<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Attendee;
use App\Models\Ticket;
use Illuminate\Http\Request;

class StatController extends Controller
{

    /**
     * [tickets description]
     * @return [type] [description]
     */
    public function tickets()
    {
        $weekend = Ticket::whereIn('id', [1, 4, 12])->sum('quantity_sold');
        $friday = Ticket::whereIn('id', [2, 10])->sum('quantity_sold');
        $saturday = Ticket::whereIn('id', [3, 11])->sum('quantity_sold');

        return response()->json([
            'weekend' => $weekend,
            'friday' => $friday,
            'saturday' => $saturday
        ]);
    }

    /**
     * [checkins description]
     * @return [type] [description]
     */
    public function checkins()
    {
        return response()->json([
            'checkins' => Attendee::where('event_id', env('CURRENT_EVENT'))where('has_arrived', 1)->count()
        ]);
    }
}
