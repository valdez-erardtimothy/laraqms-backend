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

    /**
     *  return the authenticated user.
     *
     *  should be protected by auth middleware on routes file.
     */
    public function authenticated()
    {
        $user = Auth::guard('sanctum')->user();

        return response()->json(['user' => $user], 200);
    }

    public function logout(Request $request)
    {
        // logout SPA
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
