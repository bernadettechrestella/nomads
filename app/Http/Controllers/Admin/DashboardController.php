<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transactions;
use App\Models\TravelPackages;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.admin.dashboard', [
            'travel_packages' => TravelPackages::count(),
            'transactions' => Transactions::count(),
            'transactions_pending' => Transactions::where('transactions_status', 'PENDING')->count(),
            'transactions_success' => Transactions::where('transactions_status', 'SUCCESS')->count(),
        ]);
    }
}
