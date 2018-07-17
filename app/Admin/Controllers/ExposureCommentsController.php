<?php

namespace App\Admin\Controllers;

use App\Models\Exposure;
use App\Models\ExposureComment;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ExposureCommentsController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     * @return Content
     */
    public function index(Exposure $exposure)
    {
        return Admin::content(function (Content $content) use ($exposure) {

            $content->header($exposure->name . ' - 评论列表');

            $content->body($this->grid($exposure));
        });
    }

    /**
     * Make a grid builder.
     * @return Grid
     */
    protected function grid($exposure)
    {
        return Admin::grid(ExposureComment::class, function (Grid $grid) use ($exposure) {

            $grid->model()->where('exposure_id', $exposure->id);

            $grid->user()->avatar('头像')->image('', 40);
            $grid->user()->name('评论人');
            $grid->content('评论内容');
            $grid->created_at('评论时间')->sortable();


            // 不在页面显示 `新建` 按钮，因为我们不需要在后台新建用户
            $grid->disableCreateButton();

            $grid->actions(function ($actions) {

                // 不在每一行后面展示删除按钮
                $actions->disableDelete();

                // 不在每一行后面展示编辑按钮
                $actions->disableEdit();
            });

            $grid->tools(function ($tools) {

                // 禁用批量删除按钮
                $tools->batch(function ($batch) {
                    $batch->disableDelete();
                });
            });
        });
    }

    /**
     * Make a form builder.
     * @return Form
     */
    protected function form()
    {
        return Admin::form(ExposureComment::class, function (Form $form) {

            $form->display('id', 'ID');

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
