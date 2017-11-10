<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/9/29
 * Time: 7:35
 */

namespace App\Http\Controllers\App;


use App\Http\Controllers\Controller;

use App\Models\Carmodel;
use App\Models\Coterie;
use App\Models\User;
use App\Models\Userscar;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller
{
    public function carVerify(Request $request){
        $res = [];
        $cars = new Userscar;
        $cars->user_id = $request->user()->id;
        $cars->car_model_id = $request->get('car_model');
        $cars->verify_pic1 = $request->get('verify_pic1');
        $cars->verify_pic2 = $request->get('verify_pic2');
        $cars->is_pass = 1;
        $cars_saved = $cars->save();

        if ($cars_saved) {
            # code...
            $res['code'] = "200";
            $res['data'] = "提交成功";
        }else{
            $res['code'] = "400";
            $res['data'] = "提交失败";
            return json_encode($res);
        }
        return json_encode($res);
    }

    public function usersCar(Request $request){
        $res = [];
        $cars = Userscar::where('user_id',$request->user()->id )->get();
        foreach ($cars as $car){
            $models = Carmodel::where('car_model_id',$car['car_model_id'])->get();
            if ($models->count()){
                $modelName = $models->first()->car_model_name;
                $brandName = Carmodel::where('car_model_id',$car['car_model_id'])->first()->car_brand->car_brand_name;
            }else{
                $modelName = "未知车型";
                $brandName = "未知品牌";
            }
            $car['brand'] = $brandName;
            $car['model'] = $modelName;
        }
        if ($cars->count()) {
            # code...
            $res['code'] = "200";
            $res['data'] = $cars;
        }else{
            $res['code'] = "400";
            $res['data'] = "没有车辆";
            return json_encode($res);
        }
        return json_encode($res);
    }

    public function getUserInfo(Request $request){
        $res = [];
        $user = User::where('id',$request->user()->id)->get();

        if ($user->count()) {
            # code...
            $res['code'] = "200";
            $res['data'] = $user;
        }else{
            $res['code'] = "400";
            $res['data'] = "用户不存在";
            return json_encode($res);
        }
        return json_encode($res);
    }

    public function saveUserInfo(Request $request){
        $res = [];
        $user = User::where('id',$request->user()->id)->first();
        $user->name = $request->get('name');
        $user->head_pic = $request->get('head_pic');
        $user->description = $request->get('description');
        $user->birthday = $request->get('birthday');
        $user->position = $request->get('position');
        $user->city = $request->get('city');
        $user_saved = $user->save();

        if ($user_saved) {
            # code...
            $res['code'] = "200";
            $res['data'] = "修改成功";
        }else{
            $res['code'] = "400";
            $res['data'] = "修改失败";
            return json_encode($res);
        }
        return json_encode($res);
    }

    public function multipics(Request $request){
        if($request->hasFile('images')){
            foreach($request->file('images') as $file) {
                $file->move(base_path().'/public/uploads/', $file->getClientOriginalName());
            }
            return "1";
        }
    }

    //上传图片
    public function uploadPic(Request $request){
        if ($request->hasFile('file')){
            $file =$request->file('file');
            $data = $request->all();
            $rules = [
                'file'    => 'max:5120',
            ];
            $messages = [
                'file.max'    => '文件过大,文件大小不得超出5MB',
            ];

            $validator = Validator::make($data, $rules, $messages);
            if ($validator->passes()) {
                $realPath = $file->getRealPath();
                $destPath = 'uploads/userPics/'.$request->user()->id.'/';
                $savePath = $destPath.''.date('Ymd', time());
                is_dir($savePath) || mkdir($savePath,0777,true);  //如果不存在则创建目录
                $name = $file->getClientOriginalName();
                $ext = $file->getClientOriginalExtension();

                $check_ext = in_array($ext, ['gif', 'jpg', 'jpeg', 'png'], true);

                if ($check_ext) {
                    $uniqid = uniqid().'_'.date('s');
                    $oFile = $uniqid.'o.'.$ext;
                    $fullfilename = $savePath.'/'.$oFile;  //原始完整路径
                    if ($file->isValid()) {
                        $uploadSuccess = $file->move($savePath, $oFile);  //移动文件
                        $res['code'] = "200";
                        $res['data'] = substr_replace($fullfilename,'',0,8);
                    } else {
                        $res['code'] = "400";
                        $res['data'] = '文件校验失败';
                    }
                } else {
                    $res['code'] = "400";
                    $res['data'] = '文件类型不允许,请上传常规的图片(gif、jpg、jpeg与png)文件';
                }
            } else {
                $res['code'] = "400";
                $res['data'] = $validator->messages()->first();
            }

        }else{
            $res['code'] = "400";
            $res['data'] = "未上传文件";
        }

        return json_encode($res);
    }

    public function userList(Request $request){
        $res = [];
        //->where('id','!=', [$request->user()->id])
        $userlist = User::where(['city'=>$request->get('city')])->where('id','!=', [$request->user()->id])->get();

        $position = explode(",",$request->get('position'));
        foreach ($userlist as $user){
            if (){

            }
            $userposition = explode(",",$user->position);
            $user['length'] = $this->distanceBetween($position[0],$position[1],$userposition[0],$userposition[1]);
        }
        $sorted = $userlist->sortBy(function ($product, $key) {
            return $product['length'];
        });

        if ($userlist->count()) {
            # code...
            $res['code'] = "200";
            $res['data'] = $sorted->values()->all();
        }else{
            $res['code'] = "400";
            $res['data'] = "暂无数据";
            return json_encode($res);
        }
        return json_encode($res);
    }

    private function distanceBetween($fP1Lat, $fP1Lon, $fP2Lat, $fP2Lon){
        $fEARTH_RADIUS = 6378137;
        //角度换算成弧度
        $fRadLon1 = deg2rad($fP1Lon);
        $fRadLon2 = deg2rad($fP2Lon);
        $fRadLat1 = deg2rad($fP1Lat);
        $fRadLat2 = deg2rad($fP2Lat);
        //计算经纬度的差值
        $fD1 = abs($fRadLat1 - $fRadLat2);
        $fD2 = abs($fRadLon1 - $fRadLon2);
        //距离计算
        $fP = pow(sin($fD1/2), 2) +
            cos($fRadLat1) * cos($fRadLat2) * pow(sin($fD2/2), 2);
        return intval($fEARTH_RADIUS * 2 * asin(sqrt($fP)) + 0.5);
    }
}