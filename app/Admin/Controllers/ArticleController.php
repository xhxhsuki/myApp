<?php

namespace App\Admin\Controllers;

use App\Models\Article;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ArticleController extends Controller
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

            $content->header('文章');
            $content->description('保养小知识');

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

            $content->header('文章');
            $content->description('保养小知识');

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

            $content->header('文章');
            $content->description('保养小知识');

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
        return Admin::grid(Article::class, function (Grid $grid) {

            $grid->article_id('ID')->sortable();
            $grid->article_title('标题');
            $grid->article_pic('封面')->image();
            $grid->created_at('创建时间');
            $states = [
                'on'  => ['value' => 0, 'text' => '是', 'color' => 'success'],
                'off' => ['value' => 1, 'text' => '否', 'color' => 'danger'],
            ];
            $grid->article_is_public('是否显示')->switch($states);  //0: 公开 1：不公开
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Article::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('article_title','文章标题')->rules('required');
            $form->text('article_subtitle','文章副标题')->rules('required');
            $form->textarea('article_description','文章摘要')->rules('nullable');
            $form->image('article_pic','文章封面')->uniqueName()->rules('required');
            $form->editor('article_content','文章内容')->rules('required');
            $form->number('article_views','浏览次数')->rules('nullable');
            $statess = [
                'on'  => ['value' => 0, 'text' => '是', 'color' => 'success'],
                'off' => ['value' => 1, 'text' => '否', 'color' => 'danger'],
            ];
            $form->switch('article_is_public','是否显示')->states($statess);
            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');
        });
    }
}
