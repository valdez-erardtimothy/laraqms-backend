<?php

namespace App\Services;

use App\Http\Requests\EnqueueRequest;
use App\Models\WaitingCustomer;
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
        $fields = array_merge(
            $request->all(),
            ['queue_token' => static::generateToken()]
        );
        $customer = WaitingCustomer::create($fields);
        return $customer;
    }

    protected static function generateToken()
    {
        return Str::random();
    }
}
