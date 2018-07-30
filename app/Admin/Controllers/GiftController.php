<?php

namespace App\Admin\Controllers;

use App\Models\Gift;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class GiftController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('礼物列表');

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

            $content->header('礼物编辑');

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

            $content->header('礼物创建');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Gift::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->title('名称');
            $grid->image('图片')->image('', 60);
            $grid->price('价格')->sortable();
            $grid->sort('排序')->sortable();

            $grid->created_at('创建时间')->sortable();
        });
    }

    /**
     * Make a form builder.
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Gift::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->text('title', '名称')->rules('required');
            $form->image('image', '图片')->uniqueName()->move('gifts')->rules('required|image');
            $form->text('price', '价格')->rules('required|numeric|min:0.01');
            $form->text('sort', '排序')->default(0)->rules('required|integer');


            $form->display('created_at', '创建时间');
        });
    }
}
