<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;

class NewsController extends Controller
{

    public function index(Request $request, NewsCategory $category, News $news)
    {

        $categories = $category->defaultSort()->get();
        $builder = $news->defaultSort()->with('category');

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
                $query->where('title', 'like', $like);
            });
        }

        // 是否有提交 time 参数
        if ($time = $request->input('time', ''))
        {
            switch ($time)
            {
                case '7_days':
                    break;
                case 'last_month':
                    break;
                case 'half_year':
                    break;
            }
        }

        $news = $builder->paginate(5);


        return view('news.index', [
            'categories' => $categories,
            'news' => $news,
            'filters' => [
                'category' => $_category,
                'search' => $search,
                'time' => $time,
            ]
        ]);
    }

    public function show(News $news)
    {
        $news->load('category');

        return view('news.show', [
            'news' => $news,
        ]);
    }
}
