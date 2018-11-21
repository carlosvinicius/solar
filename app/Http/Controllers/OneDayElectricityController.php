<?php

namespace App\Http\Controllers;

use \DateTime;
use App\Models\OneDayElectricity;
use App\Models\Panel;
use Illuminate\Http\Request;

class OneDayElectricityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $panel     = Panel::where('serial', $request->panel_serial)->firstOrFail();
        $yesterday = new DateTime('yesterday');

        return OneDayElectricity
                ::where('panel_id', $panel->id)
                ->where('day', $yesterday->format('Y-m-d'))
                ->select(['day', 'sum', 'min', 'max','average'])
                ->get();
    }
}
