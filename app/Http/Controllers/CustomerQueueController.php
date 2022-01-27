<?php

namespace App\Http\Controllers;

use App\Http\Requests\EnqueueRequest;
use App\Services\CustomerQueue;
use Illuminate\Http\Request;

class CustomerQueueController extends Controller
{
    protected $queue_service;
    public function __construct(CustomerQueue $queue_service)
    {
        $this->queue_service = $queue_service;
    }
    //

    public function enqueue(EnqueueRequest $request)
    {
        $queued = $this->queue_service->enqueue($request);
        return response()->json([
            'customer' => $queued
        ]);
    }
}
