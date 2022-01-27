<?php

namespace App\Http\Controllers\Teller;

use App\Http\Controllers\Controller;
use App\Services\TellerDashboard;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function __construct(protected TellerDashboard $dashboard)
    {
    }

    public function __invoke()
    {
        $data = $this->dashboard->getDashboardData();
        return response()->json($data);
    }
}
