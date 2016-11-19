<?php

namespace App\Http\Controllers;

use App\Models\Organiser;
use Illuminate\Http\Request;
use Image;

class OrganiserController extends MyBaseController
{
    /**
     * Show the select organiser page
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function showSelectOrganiser()
    {
        return view('ManageOrganiser.SelectOrganiser');
    }

    /**
     * Show the create organiser page
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function showCreateOrganiser()
    {
        return view('ManageOrganiser.CreateOrganiser');
    }

    /**
     * Create the organiser
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postCreateOrganiser(Request $request)
    {
        $organiser = Organiser::createNew(false, false, true);

        if (!$organiser->validate($request->all())) {
            return response()->json([
                'status'   => 'error',
                'messages' => $organiser->errors(),
            ]);
        }

        $organiser->name = $request->get('name');
        $organiser->about = $request->get('about');
        $organiser->email = $request->get('email');
        $organiser->facebook = $request->get('facebook');
        $organiser->twitter = $request->get('twitter');
        $organiser->confirmation_key = str_random(15);

        if ($request->hasFile('organiser_logo')) {
            $filename = str_slug($organiser->name).'-logo-'.$organiser->id.'.'.strtolower($request->file('organiser_logo')->getClientOriginalExtension());

            // Image Directory
            $imageDirectory = public_path() . '/' . config('attendize.organiser_images_path');

            // Paths
            $relativePath = config('attendize.organiser_images_path').'/'.$filename;
            $absolutePath = public_path($relativePath);

            $request->file('organiser_logo')->move($imageDirectory, $filename);

            if (file_exists($absolutePath)) {
                $organiser->logo_path = $relativePath;
            }
        }

        $organiser->save();

        session()->flash('message', 'Successfully Created Organiser.');

        return response()->json([
            'status'      => 'success',
            'message'     => 'Refreshing..',
            'redirectUrl' => route('showOrganiserEvents', [
                'organiser_id' => $organiser->id,
                'first_run'    => 1
            ]),
        ]);
    }
}
