<?php

namespace App\Admin\Controllers;

use App\Models\Active;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ActiveController extends Controller
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
        return Admin::grid(Active::class, function (Grid $grid) {

            $grid->model()->orderBy('active_order', 'desc');
            $grid->active_order('排序')->editable();
            $grid->active_title('活动标题');
            $grid->active_pic('活动封面')->image();
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
        return Admin::form(Active::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('active_order','活动排序');
            $form->text('active_title','活动标题');
            $timename = date('Ymd');
            $form->image('active_pic','活动封面')->move('active/'.$timename)->uniqueName();
            $form->text('active_url_id','店id');
            $statess = [
                'on'  => ['value' => 0, 'text' => '是', 'color' => 'success'],
                'off' => ['value' => 1, 'text' => '否', 'color' => 'danger'],
            ];
            $form->switch('active_is_public','是否显示')->states($statess);
            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');
        });
    }
}
