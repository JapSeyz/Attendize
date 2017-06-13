<?php

namespace App\Http\Controllers\API;

use App\Models\Attendee;
use App\Models\Guest;
use App\Models\Order;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppController extends ApiBaseController
{

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function attendees(Request $request)
    {
        $tickets = Ticket::pluck('title', 'id');
        $attendees = Attendee::scope($this->account_id)->where('event_id', env('CURRENT_EVENT'))->get();
        $attendees->transform(function($attendee) use($tickets){
            $attendee->ticket = $tickets[$attendee->ticket_id];
            return $attendee;
        });

        return $attendees;
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
        if ( ! $request->has_arrived) {
            $message = 'Brugeren er nu tjekket ud';
        }

        return response()->json([
            'title' => $message,
            'body' => $attendee->fullName,
            ]);
    }

    /**
     * @param \illuminate\http\request $request
     *
     * @return bool
     */
    public function checkIn(Request $request)
    {
        $user = auth()->guard('api')->user();
        \Log::debug($user->name . ' (' . $user->id . ') attempted to checkin the reference-code: ' . $request->code);

        $attendee = Attendee::where('event_id', env('CURRENT_EVENT'))
        ->where('private_reference_number', $request->code)
        ->first();

        if ( ! $attendee) {
            \Log::debug('the reference-code: ' . $request->code . ' was invalid');

            return response()->json([
                'title' => 'Ukendt Kode',
                'body' => 'Billetten tilhører ikke Musikliv',
                ], 400);
        }

        \Log::debug('the reference-code: ' . $request->code . ' came back to attendee: ' . $attendee->name . ' (' . $attendee->id . ') ');


        // Make sure that the ticket is valid
        if($attendee->ticket->valid_from || !$attendee->ticket->valid_to){
            $today = date('Y-m-d H:i:s');

            if($attendee->ticket->valid_from > $today || $attendee->ticket->valid_to < $today){
                \Log::debug('The attendee' . $attendee->name . ' (' . $attendee->id . '), tried to use a ticket outside its valid-time');
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Billetten er ikke gyldig på dette tidspunkt',
                    'id'      => $attendee->id,
                    ]);
            }
        }

        if ($attendee->is_cancelled) {
            \Log::debug('the attendee: ' . $attendee->id . ' was cancelled');

            return response()->json([
                'title' => 'Ugyldig Billet',
                'body' => 'Denne billet er ikke gyldig',
                ], 400);
        }

        if ($attendee->has_arrived) {
            $arrivalTime = $attendee->arrival_time->format('H:i - d/m');

            \Log::debug('the attendee: ' . $attendee->id . ' had already arrived at: ' . $arrivalTime);

            return response()->json([
                'title' => 'Allerede tjekket ind',
                'body' => $arrivalTime,
                ], 400);
        }

        $attendee->has_arrived = 1;
        $attendee->arrival_time = Carbon::now()->format('Y-m-d H:i:s');

        $attendee->save();

        \Log::debug('the attendee: ' . $attendee->id . ' has been marked as arrived at ' . $attendee->arrival_time);

        return response()->json([
            'title' => 'Brugeren er nu tjekket ind',
            'body' => $attendee->fullName,
            'id' => $attendee->id,
            ]);
    }

    /**
     * Tickets to sell at the entrance
     *
     * @return mixed
     */
    public function tickets()
    {
        return Ticket::where('is_purchasable_in_app', 1)->orderBy('sort_order')->get();
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function purchase(Request $request)
    {
        $user = auth()->guard('api')->user();

        \Log::debug($user->name . ' (' . $user->id . ') attempted to register a new ticket with id ' . $request->ticket_id);

        $ticket_id = $request->ticket_id;
        $ticket = Ticket::findOrFail($ticket_id);

        $order = new Order;
        $order->account_id = 1;
        $order->order_status_id = 1;
        $order->first_name = $user->first_name;
        $order->last_name = $user->last_name;
        $order->email = 'indgang@ikastmusikliv.dk';
        $order->amount = $ticket->price;
        $order->event_id = env('CURRENT_EVENT');
        $order->is_payment_received = 1;
        $order->save();

        \Log::debug($user->name . ' (' . $user->id . ') registered a new "' . $ticket->title . '" ticket');

        $attendee = new Attendee;
        $attendee->order_id = $order->id;
        $attendee->event_id = $order->event_id;
        $attendee->ticket_id = $ticket_id;
        $attendee->account_id = 1;
        $attendee->first_name = 'indgang';
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
        $user = auth()->guard('api')->user();

        $order = Order::findOrFail($request->order_id);
        \Log::debug($user->name . ' (' . $user->id . ') cancelled the order: ' . $order->id);

        $order->attendees()->delete();
        $order->delete();

        return response()->json([
            'title' => 'Billetten er fortrudt',
            'body' => '',
            ]);
    }


    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function guests(Request $request)
    {
        return Guest::orderBy('name')->get();
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    public function guest(Request $request)
    {
        $guest = Guest::where('id', $request->guest_id)->first();

        $guest->has_arrived = $request->has_arrived;
        $guest->arrival_time = $request->arrival_time;

        $guest->save();

        $message = 'Gæsten er nu tjekket ind';
        if ( ! $request->has_arrived) {
            $message = 'Gæsten er nu tjekket ud';
        }

        return response()->json([
            'title' => $message,
            'body' => $guest->name,
            ]);
    }
}
