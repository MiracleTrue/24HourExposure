<?php

namespace App\Http\Controllers;

use App\Models\Exposure;
use App\Models\ExposureCategory;
use App\Models\ExposureComment;
use App\Models\News;
use Illuminate\Http\Request;

class ExposuresController extends Controller
{
    //
    public function index(Request $request, Exposure $exposure, ExposureCategory $category, News $news)
    {
        $lbs = $request->session()->get('LBS');
        $categories = $category->defaultSort()->get();
        $today_news = $news->defaultSort()->limit(2)->get();

        $builder = $exposure->where('location_id', $lbs->id)->with(['order_items', 'category'])->defaultSort();

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
        if ($sort = $request->input('sort', ''))
        {
            switch ($sort)
            {
                case 'created_time_desc':
                    $builder->orderBy('created_at', 'desc');
                    break;
                case 'created_time_asc':
                    $builder->orderBy('created_at', 'asc');
                    break;
                case 'gift_amount_more':
                    $builder->orderBy('gift_amount', 'desc');
                    break;
                case 'gift_amount_less':
                    $builder->orderBy('gift_amount', 'asc');
                    break;
            }
        }

        $exposures = $builder->paginate(5);

        return view('exposures.index', [
            'categories' => $categories,
            'exposures' => $exposures,
            'lbs' => $lbs,
            'today_news' => $today_news,
            'filters' => [
                'category' => $_category,
                'search' => $search,
                'sort' => $sort,
            ]
        ]);
    }


    public function show(Exposure $exposure)
    {

        $exposure = $exposure->load(['category', 'user']);

        $comments = $exposure->comments()->defaultSort()->get();
        $comments->load(['user']);

        return view('exposures.show', [
            'exposure' => $exposure,
            'comments' => $comments,
        ]);

    }
}
