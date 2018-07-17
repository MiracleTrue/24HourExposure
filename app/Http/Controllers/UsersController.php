<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Http\Requests\UserRequest;
use App\Models\Exposure;
use App\Models\ExposureCategory;
use App\Models\ExposureComment;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    public function index(Request $request)
    {
        return view('users.index', [
            'user' => $request->user(),
        ]);
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);

        return view('users.edit', [
            'user' => $user,
        ]);
    }

    public function update(UserRequest $request, ImageUploadHandler $uploader, User $user)
    {
        $this->authorize('update', $user);

        $data = $request->only('name', 'avatar');


        if ($request->hasFile('avatar'))
        {
            $data['avatar'] = $uploader->uploadOriginal($request->avatar);
        }

        $user->update($data);

        return [
            'user' => User::find($user->id),
        ];

//        return redirect()->route('users.edit', $user->id)->with('success', '个人资料更新成功！');
    }

    public function releasedExposures(Request $request, ExposureCategory $category)
    {
        $categories = $category->defaultSort()->get();

        $builder = $request->user()->exposures()->with(['order_items', 'category'])->defaultSort();

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

        // 是否有提交 time 参数
        if ($time = $request->input('time', ''))
        {
            switch ($time)
            {
                case '7_days':
                    $builder->where('created_at', '>', now()->subDays(7));
                    break;
                case 'last_month':
                    $builder->where('created_at', '>', now()->subMonth());
                    break;
                case 'half_year':
                    $builder->where('created_at', '>', now()->subMonths(6));
                    break;
            }
        }

        $exposures = $builder->paginate(5);

        return view('users.released_exposures', [
            'categories' => $categories,
            'exposures' => $exposures,
            'filters' => [
                'category' => $_category,
                'search' => $search,
                'time' => $time,
            ]
        ]);
    }

    public function commentedExposures(Request $request, Exposure $exposure, ExposureCategory $category)
    {

        $categories = $category->defaultSort()->get();

        $exposure_ids = ExposureComment::where('user_id', $request->user()->id)->get()->pluck('exposure_id')->unique()->toArray();

        $builder = $exposure->whereIn('id', $exposure_ids)->with(['order_items', 'category'])->defaultSort();

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

        // 是否有提交 time 参数
        if ($time = $request->input('time', ''))
        {
            switch ($time)
            {
                case '7_days':
                    $builder->where('created_at', '>', now()->subDays(7));
                    break;
                case 'last_month':
                    $builder->where('created_at', '>', now()->subMonth());
                    break;
                case 'half_year':
                    $builder->where('created_at', '>', now()->subMonths(6));
                    break;
            }
        }

        $exposures = $builder->paginate(5);


        return view('users.commented_exposures', [
            'categories' => $categories,
            'exposures' => $exposures,
            'filters' => [
                'category' => $_category,
                'search' => $search,
                'time' => $time,
            ]
        ]);
    }

}
