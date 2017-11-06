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
        $cars = User::find($request->user()->id)->cars;
        foreach ($cars as $car){
            $models = Carmodel::where('id',$car['car_model_id'])->get();
            if ($models->count()){
                $modelName = $models->first()->car_model_name;
                $brandName = Carmodel::find($car['car_model_id'])->car_brand->car_brand_name;
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
    //上传图片
    public function uploadPic(Request $request)
    {
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
            $res['data'] = 'error|失败原因为：非法传参';
            if ($validator->passes()) {
                $realPath = $file->getRealPath();
                $destPath = 'userPics/'.$request->user()->id.'/';
                $savePath = $destPath.''.date('Ymd', time());
                is_dir($savePath) || mkdir($savePath);  //如果不存在则创建目录
                $name = $file->getClientOriginalName();
                $ext = $file->getClientOriginalExtension();

                $check_ext = in_array($ext, ['gif', 'jpg', 'jpeg', 'png'], true);

                if ($check_ext) {
                    $uniqid = uniqid().'_'.date('s');
                    $oFile = $uniqid.'o.'.$ext;
                    $fullfilename = '/'.$savePath.'/'.$oFile;  //原始完整路径
                    if ($file->isValid()) {
                        $uploadSuccess = $file->move($savePath, $oFile);  //移动文件
                        $oFilePath = $savePath.'/'.$oFile;
                        $res['code'] = "200";
                        $res['data'] = $fullfilename;
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
}