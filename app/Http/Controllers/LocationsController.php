<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocationsController extends Controller
{
    //

    public function relocation(Request $request)
    {

        $request->session()->forget('LBS');

        return redirect()->back();
    }
}
