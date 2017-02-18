<?php

namespace app\Http\Controllers\API;

use App\Models\Attendee;
use App\Models\Order;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppController extends ApiBaseController
{

    public function authenticate(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (auth()->attempt($credentials)) {
            return response()->json([
                'title' => 'Success',
                'body' => 'Du er nu logget ind',
                'api_key' => auth()->user()->api_token,
            ]);
        }

        return response()->json([
            'title' => 'Brugeren blev ikke fundet',
            'body' => 'Prøv igen',
        ],401);
    }

    /**
     * @param Request $request
     *
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
        if (!$request->has_arrived) {
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
        $attendee = Attendee::where('event_id', env('CURRENT_EVENT'))
            ->where('private_reference_number', $request->code)
            ->first();

        if (!$attendee) {
            return response()->json([
                'title' => 'Ukendt Kode',
                'body' => 'Billetten tilhører ikke Musikliv',
            ], 400);
        }

        if ($attendee->is_cancelled) {
            return response()->json([
                'title' => 'Ugyldig Billet',
                'body' => 'Denne billet er ikke gyldig',
            ], 400);
        }

        if ($attendee->has_arrived) {
            $arrivalTime = $attendee->arrival_time->format('H:i - d/m');

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

    /**
     * Tickets to sell at the Entrance
     *
     * @return mixed
     */
    public function tickets()
    {
        return Ticket::where('is_purchasable_in_app', 1)->orderBy('sort_order')->get();
    }

    public function purchase(Request $request)
    {
        $user = auth()->guard('api')->user();
        $ticket_id = $request->ticket_id;
        $ticket = Ticket::findOrFail($ticket_id);

        $order = new Order;
        $order->account_id = 1;
        $order->order_status_id = 1;
        $order->first_name = $user->first_name;
        $order->last_name = $user->last_name;
        $order->email = 'Indgang@ikastmusikliv.dk';
        $order->amount = $ticket->price;
        $order->event_id = env('CURRENT_EVENT');
        $order->is_payment_received = 1;
        $order->save();


        $attendee = new Attendee;
        $attendee->order_id = $order->id;
        $attendee->event_id = $order->event_id;
        $attendee->ticket_id = $ticket_id;
        $attendee->account_id = 1;
        $attendee->first_name = 'Indgang';
        $attendee->last_name = '';
        $attendee->email = '';
        $attendee->has_arrived = 1;
        $attendee->arrival_time = date('Y-m-d H:i:s');
        $attendee->reference_index = 1;
        $attendee->save();

        return response()->json([
            'title' => 'Billetten er blevet købt',
            'body' => $ticket->title,
            'order_id' => $order->id,
        ]);
    }

    public function cancelPurchase(Request $request)
    {
        $order = Order::findOrFail($request->order_id);

        $order->attendees()->delete();
        $order->delete();

        return response()->json([
            'title' => 'Billetten er fortrudt',
            'body' => '',
        ]);
    }
}