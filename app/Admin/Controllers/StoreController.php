<?php

namespace App\Admin\Controllers;

use App\Models\Store;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class StoreController extends Controller
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
        return Admin::grid(Store::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->store_title('店铺名称');
            $states = [
                'on'  => ['value' => 0, 'text' => '是', 'color' => 'success'],
                'off' => ['value' => 1, 'text' => '否', 'color' => 'danger'],
            ];
            $grid->store_is_public('是否显示')->switch($states);  //0: 公开 1：不公开
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Store::class, function (Form $form) {

            $form->display('id', '店铺ID');

            $form->text('category_id','分类');
            $form->text('store_title','店铺名称');
            $timename = date('Ymd');
            $form->multipleImage('store_sliders','店铺轮播')->removable()->move('store/'.$timename)->uniqueName();
            $form->text('store_stars','店铺评分');
            $form->text('store_description','店铺描述');
            $form->text('store_position','店铺坐标');
            $form->text('store_address','店铺地址');
            $form->text('store_tel','店铺电话');
            $form->text('store_business_hours','店铺营业时间');
            $form->editor('store_content','店铺详情');

            $statess = [
                'on'  => ['value' => 0, 'text' => '是', 'color' => 'success'],
                'off' => ['value' => 1, 'text' => '否', 'color' => 'danger'],
            ];
            $form->switch('store_is_public','是否开启')->states($statess);
            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        });
    }
}
