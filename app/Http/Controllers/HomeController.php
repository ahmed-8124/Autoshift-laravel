<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Make;

class HomeController extends Controller
{
    public function index()
    {
        $featured   = Ad::with('make')->active()->featured()->latest()->take(8)->get();
        $latestCars = Ad::with('make')->active()->ofType('car')->latest()->take(4)->get();
        $latestBikes= Ad::with('make')->active()->ofType('bike')->latest()->take(4)->get();
        $makes      = Make::withCount(['ads' => fn($q) => $q->active()])->orderBy('name')->take(6)->get();
        $totalCars  = Ad::active()->ofType('car')->count();
        $totalBikes = Ad::active()->ofType('bike')->count();
        $allMakes   = Make::orderBy('name')->get();
        $cities     = config('autoshift.cities');

        return view('home.index', compact(
            'featured', 'latestCars', 'latestBikes',
            'makes', 'totalCars', 'totalBikes', 'allMakes', 'cities'
        ));
    }
}
