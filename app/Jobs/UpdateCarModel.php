<?php

namespace App\Jobs;

use App\Models\Carbrand;
use App\Models\Carmodel;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateCarModel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $url="https://www.autohome.com.cn/ashx/AjaxIndexCarFind.ashx?type=1";
        $result = json_decode($this->getData($url));

        foreach ($result->result->branditems as $brand){
            Carbrand::updateOrCreate(
                ['car_brand_id' => $brand->id, 'car_brand_name' =>$brand->name]
            );
        }

        $brands = Carbrand::pluck('car_brand_id');
        foreach($brands as $key=>$brand){

            $url2="https://www.autohome.com.cn/ashx/AjaxIndexCarFind.ashx?type=3&value=".$brand;

            $result2 = json_decode($this->getData($url2),true);
            $list = array_collapse(array_pluck($result2['result']['factoryitems'],'seriesitems'));

            foreach ($list as $model){
                Carmodel::updateOrCreate(
                    ['car_model_id' => $model['id'], 'car_model_name' =>$model['name'] , 'brand_id'=>$brand]
                );
            }
            file_put_contents("progress.log",$brands->count().','.$key);
        }
        file_put_contents("progress.log",'0000');
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
