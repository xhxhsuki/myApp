<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Carbrand;
use App\Models\Carmodel;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;

class UpdateController extends Controller
{
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('车型更新');

            $url="https://www.autohome.com.cn/ashx/AjaxIndexCarFind.ashx?type=1";
            $result = json_decode($this->getData($url));

            foreach ($result->result->branditems as $brand){
                Carbrand::updateOrCreate(
                    ['car_brand_id' => $brand->id, 'car_brand_name' =>$brand->name]
                );
            }
            $content->row(Dashboard::title());


            $content->row(view('admin.charts.chart'));

        });
    }

    public function modelUpdate()
    {
        return Admin::content(function (Content $content) {

            $content->header('车型更新');


            $brands = Carbrand::pluck('car_brand_id');
            foreach($brands as $brand){

                $url="https://www.autohome.com.cn/ashx/AjaxIndexCarFind.ashx?type=3&value=".$brand;

                $result = json_decode($this->getData($url),true);
                $list = array_collapse(array_pluck($result['result']['factoryitems'],'seriesitems'));

                foreach ($list as $model){
                    Carmodel::updateOrCreate(
                        ['car_model_id' => $model['id'], 'car_model_name' =>$model['name'] , 'brand_id'=>$brand]
                    );
                }

            }
            $content->row(Dashboard::title());


            $content->row(view('admin.charts.chart'));

        });
    }

    private function getData($url){
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        $tmpInfo = curl_exec($curl);
        curl_close($curl);

        return mb_convert_encoding($tmpInfo, 'utf-8', 'GBK,UTF-8,ASCII');
    }
}
