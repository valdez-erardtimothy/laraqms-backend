<?php

namespace App\Services;

use App\Http\Requests\EnqueueRequest;
use App\Models\WaitingCustomer;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

/**
 *
 */
class CustomerQueue
{

    /**
     * @param EnqueueRequest $request newly constructed instance (not-saved)
     */
    public function enqueue(EnqueueRequest $request): WaitingCustomer
    {
        $token =  static::generateToken();
        $fields = array_merge(
            $request->all(),
            ['queue_token' => $token]
        );
        $customer = WaitingCustomer::create($fields);
        static::sendTokenToUser($token);
        return $customer;
    }

    public function loadFromToken($token): ?WaitingCustomer
    {
        return WaitingCustomer::findByToken($token);
    }

    protected static function generateToken()
    {
        return Str::random();
    }

    protected static function sendTokenToUser($token)
    {
        return Cookie::queue('queue_token', $token, 0);
    }
}
