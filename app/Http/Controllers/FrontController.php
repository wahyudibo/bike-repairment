<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\WorkUnit;
use App\BikeType;

class FrontController extends Controller
{
    public function index()
    {
        $workUnits = WorkUnit::all();
        $bikeTypes = BikeType::all();
        $googleMapApiKey = env('GOOGLE_MAPS_API_KEY');

        return view('front', compact(
            'workUnits',
            'bikeTypes',
            'googleMapApiKey'
        ));
    }
}
