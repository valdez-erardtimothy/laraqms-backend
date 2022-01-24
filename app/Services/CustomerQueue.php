<?php

namespace App\Services;

use App\Http\Requests\EnqueueRequest;
use App\Models\WaitingCustomer;
use Illuminate\Support\Facades\DB;

/**
 *
 */
class CustomerQueue
{

    /**
     * @param EnqueueRequest $request newly constructed instance (not-saved)
     */
    public function enqueue(EnqueueRequest $request): ?WaitingCustomer
    {
        $customer = null;
        DB::transaction(function () use ($customer, $request) {

            $customer = WaitingCustomer::create($request->all());
        });
        return $customer;
    }
}
