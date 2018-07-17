<?php

namespace App\Admin\Controllers;

use App\Models\Exposure;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ExposuresController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('曝光列表');

            $content->body($this->grid());
        });
    }

    public function show($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('曝光详情');

            $content->body($this->form()->view($id));
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

            $content->header('header');
            $content->description('description');

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

            $content->header('header');
            $content->description('description');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Exposure::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->category()->name('分类');
            $grid->user('曝光人')->display(function ($data) {
                return $data['name'] . "($data[phone])";
            });
            $grid->name('曝光对象');
            $grid->title('标题');
            $grid->gift_amount('礼物总金额')->sortable();
            $grid->comment_count('评论数')->sortable();

            $grid->created_at('创建时间')->sortable();


            // 不在页面显示 `新建` 按钮，因为我们不需要在后台新建用户
            $grid->disableCreateButton();

            $grid->actions(function ($actions) {
                $actions->append('<a style="margin-right:10px;" title="查看" href="' . url('admin/exposures', $actions->row->id) . '"><i class="fa fa-eye"></i></a>');
                $actions->append('<a title="评论" href="' . url('admin/exposure_comments', $actions->row->id) . '"><i class="fa fa-commenting"></i></a>');

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
        return Admin::form(Exposure::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->display('category.name', '分类');

            $form->display('user', '曝光人')->with(function ($value) {
                return "$value[name] (手机号:$value[phone]) (身份证:$value[id_card])";
            });
            $form->display('gift_amount', '礼物总金额');
            $form->display('comment_count', '评论数');
            $form->display('name', '曝光对象');
            $form->display('title', '标题');
            $form->display('content', '内容');
            $form->display('created_at', '创建时间');
        });
    }
}
