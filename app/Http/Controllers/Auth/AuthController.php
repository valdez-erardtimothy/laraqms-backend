<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Handle  authentication on SPA
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $body = [
                'message' => "login success!",
                'user' => Auth::guard('sanctum')->user()
            ];
            return response()->json($body, 200);
        }

        $body = ['message' => 'Incorrect username or password'];
        return response()->json($body, 401);
    }
}
