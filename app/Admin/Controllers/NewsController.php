<?php

namespace App\Admin\Controllers;

use App\Models\News;

use App\Models\NewsCategory;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class NewsController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('新闻列表');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('新闻编辑');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('新闻创建');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(News::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->category()->name('分类');
            $grid->image('缩略图')->image('', 60);
            $grid->title('标题');

            $grid->created_at('创建时间')->sortable();
            $grid->updated_at('更新时间')->sortable();
        });
    }

    /**
     * Make a form builder.
     * @return Form
     */
    protected function form()
    {
        return Admin::form(News::class, function (Form $form) {


            $categories = NewsCategory::all()->mapWithKeys(function ($item) {
                return [$item['id'] => $item['name']];
            });

            $form->display('id', 'ID');

            $form->select('category_id', '分类')->options($categories)->rules('required');
            $form->image('image', '缩略图')->uniqueName()->move('original/' . date('Ym', now()->timestamp))->rules('required|image');
            $form->text('title', '标题')->rules('required');
            $form->editor('content', '内容')->rules('required');


            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');
        });
    }
}
