<?php
namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Guest;
use File;
use Illuminate\Http\Request;
use Image;
use Validator;

class EventGuestController extends MyBaseController
{
    /**
     * Show the Guest Overview Page
     *
     * @param int $event_id
     *
     * @return \Illuminate\View\View
     */
    public function showGuests($event_id)
    {
        $data = $this->getEventViewData($event_id);

        return view('ManageEvent.Guests', $data);
    }

    /**
     * Return the Guest Create Modal
     *
     * @param $event_id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showCreateGuest($event_id)
    {
        return view('ManageEvent.Modals.CreateGuest')->with('event_id', $event_id);
    }


    /**
     * Persist a new Guest to the Database
     *
     * @param \Illuminate\Http\Request $request
     * @param $event_id
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Symfony\Component\HttpFoundation\File\Exception\FileException
     */
    public function postCreateGuest(Request $request, $event_id)
    {
        $guest = new Guest;
        $guest->name = $request->name;
        $guest->band = $request->band;
        $guest->event_id = $event_id;

        $guest->save();

        return response()->json([
            'status' => 'success',
            'message' => 'The guest has been created',
            'redirectUrl' => route('showEventGuests', [
                'event_id' => $event_id,
            ]),
        ]);
    }


    /**
     * Shows  'Manage Guest' modal
     *
     * @param Request $request
     * @param int $event_id
     * @param int $sponsor_id
     *
     * @return mixed
     */
    public function showEditGuest(Request $request, $event_id, $guest_id)
    {
        $data = [
            'guest' => Guest::find($guest_id),
        ];

        return view('ManageEvent.Modals.ManageGuest', $data);
    }

    /**
     * Persist Guest Changes to the Database
     *
     * @param \Illuminate\Http\Request $request
     *
     * @param $event_id
     * @param $sponsor_id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function postEditGuest(Request $request, $event_id, $guest_id)
    {
        $guest = Guest::findOrFail($guest_id);
        $guest->name = $request->name;
        $guest->band = $request->band;
        $guest->save();

        return response()->json([
            'status' => 'success',
            'message' => 'The guest has been updated',
            'redirectUrl' => route('showEventGuests', ['event_id' => $event_id]),
        ]);
    }


    /**
     * Delete a Guest
     *
     * @param \Illuminate\Http\Request $request
     *
     * @param $event_id
     * @param $sponsor_id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function postDeleteGuest(Request $request, $event_id, $sponsor_id)
    {
        Guest::where('id', $sponsor_id)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'The guest has been deleted',
            'redirectUrl' => route('showEventGuests', ['event_id' => $event_id]),
        ]);
    }
}
