<?php

namespace App\Http\Controllers;

use App\Models\Exposure;
use App\Models\ExposureCategory;
use Illuminate\Http\Request;

class ExposuresController extends Controller
{
    //
    public function index(Request $request, Exposure $exposure, ExposureCategory $category)
    {
        $lbs = $request->session()->get('LBS');
        $categories = $category->defaultSort()->get();

        $builder = $exposure->where('location_id', $lbs->id)->with(['order_items', 'order_items.gift'])->defaultSort();


        $exposures = $builder->paginate(5);

        $exposures->first()->gifts;

//        dd($exposures->first()->gifts);
//        return $exposures->first();

        return view('exposures.index', [
            'categories' => $categories,
            'exposures' => $exposures,
            'lbs' => $lbs,

        ]);
    }
}
