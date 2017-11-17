<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\UpdateCarModel;
use App\Models\Carbrand;
use App\Models\Carmodel;
use App\Repositories\TestRepository;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;

class UpdateController extends Controller
{
    public function index(TestRepository $testRepository)
    {
        return Admin::content(function (Content $content) use ($testRepository) {

            $content->header('车型更新');
            $content->description('自动更新');
            $num = $testRepository->data();
            $content->row(view('admin.plugs.update',['name' => $num]));

        });
    }

    public function start() {
        file_put_contents("progress.log",'0');

        $size=ob_get_length();
        header("Content-Length: $size");  //告诉浏览器数据长度,浏览器接收到此长度数据后就不再接收数据
        header("Connection: Close");      //告诉浏览器关闭当前连接,即为短连接
        ob_flush();
        flush();

        dispatch(new UpdateCarModel);
        exit();
    }

    public function progress() {
        return json_encode(file_get_contents("progress.log"));
    }

}
