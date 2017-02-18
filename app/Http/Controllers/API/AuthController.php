<?php

namespace app\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
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
}