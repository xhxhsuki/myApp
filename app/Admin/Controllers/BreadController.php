<?php

namespace App\Admin\Controllers;

use App\Models\Slider;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class BreadController extends Controller
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
        return Admin::grid(Slider::class, function (Grid $grid) {
            $grid->model()->where('cate', '2');
            $grid->id('ID')->sortable();
            $grid->pic('轮播图')->image();
            $grid->updated_at('更新时间');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Slider::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->hidden('cate')->value('2');
            $timename = date('Ymd');
            $form->image('pic','图片')->move('slider/'.$timename)->uniqueName();
            $form->text('forwhat','选项'); // 0 => 店铺活动， 1 => 店铺列表， 2 => 文章页
            $form->text('url','url');
            $statess = [
                'on'  => ['value' => 0, 'text' => '是', 'color' => 'success'],
                'off' => ['value' => 1, 'text' => '否', 'color' => 'danger'],
            ];
            $form->switch('slider_is_public','是否显示')->states($statess);
            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
