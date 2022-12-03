<?php

namespace App\Http\Controllers;

use App\Models\TravelPackages;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $items = TravelPackages::with(['galleries'])->get();
        return view('pages.home', [
            'items' => $items
        ]);
    }
}
