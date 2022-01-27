<?php

namespace App\Services;

use App\Models\WaitingCustomer;

class TellerDashboard
{
    public function getDashboardData()
    {
        $data['waitlist'] = WaitingCustomer::getWaitList();
        return $data;
    }
}
