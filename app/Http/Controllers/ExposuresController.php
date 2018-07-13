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

        $builder = $exposure->where('location_id', $lbs->id)->with(['order_items',])->defaultSort();

        // 是否有提交 category 参数
        if ($_category = $request->input('category', ''))
        {
            $builder->where('category_id', $_category);
        }

        // 是否有提交 search 参数
        if ($search = $request->input('search', ''))
        {
            $like = '%' . $search . '%';
            // 模糊搜索商品标题、商品详情、SKU 标题、SKU描述
            $builder->where(function ($query) use ($like) {
                $query->where('name', 'like', $like);
            });
        }

        // 是否有提交 sort 参数
        if ($soft = $request->input('sort', ''))
        {
            switch ($soft)
            {
                case 'created_time_desc':
                    break;
                case 'created_time_asc':
                    break;
                case 'gifts_money_more':
                    break;
                case 'gifts_money_less':
                    break;
            }
        }

        $exposures = $builder->paginate(5);

        return view('exposures.index', [
            'categories' => $categories,
            'exposures' => $exposures,
            'lbs' => $lbs,
            'filters' => [
                'category' => $_category,
                'search' => $search,
                'time' => $soft,
            ]
        ]);
    }
}
