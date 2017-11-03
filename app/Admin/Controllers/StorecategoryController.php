<?php

namespace App\Admin\Controllers;

use App\Models\Storecategory;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class StorecategoryController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
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
     *
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
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Storecategory::class, function (Grid $grid) {
            $grid->model()->orderBy('cate_order', 'desc');
            $grid->cate_order('排序')->editable();
            $grid->cate_name('分类名称');
            $grid->cate_pic('图标')->image();
            $states = [
                'on'  => ['value' => 0, 'text' => '是', 'color' => 'success'],
                'off' => ['value' => 1, 'text' => '否', 'color' => 'danger'],
            ];
            $grid->cate_is_public('是否显示')->switch($states);  //0: 公开 1：不公开
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Storecategory::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('cate_order','分类排序');
            $form->text('cate_name','分类名称');
            $timename = date('Ymd');
            $form->image('cate_pic','图标')->move('storecate/'.$timename)->uniqueName();
            $statess = [
                'on'  => ['value' => 0, 'text' => '是', 'color' => 'success'],
                'off' => ['value' => 1, 'text' => '否', 'color' => 'danger'],
            ];
            $form->switch('cate_is_public','是否显示')->states($statess);
            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
