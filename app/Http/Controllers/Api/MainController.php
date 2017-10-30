<?php
/**
 * Created by PhpStorm.
 * User: xhxhs
 * Date: 2017/10/30
 * Time: 14:56
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\TestRepository;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function index()
    {
        return "111";
    }

    public function articlelist()
    {
        $res = [];
        $articles = Article::where('article_is_public','0')->orderBy('created_at','desc')->select('article_id','article_title','article_subtitle','article_description','article_pic')->paginate(10);
        if ($articles->count()) {
            # code...
            $res['code'] = "200";
            $res['data'] = $articles;
        }else{
            $res['code'] = "400";
            $res['data'] = "暂无数据";
            return json_encode($res);
        }
        return json_encode($res);
    }

    public function articledetail(Request $request)
    {
        $res = [];
        $article = Article::where('article_id',$request->get('id'))->first();
        if ($article) {
            $res['code'] = "200";
            $res['data'] = $article;
        }else{
            $res['code'] = "404";
            $res['data'] = "请求的内容不存在";
            return json_encode($res);
        }
        return json_encode($res);
    }

    public function activelist()
    {
        $res = [];
        $actives = Active::where('active_is_public','0')->orderBy('created_at','desc')->select('active_id','active_title','active_subtitle','active_description','active_pic','active_url')->paginate(10);
        if ($actives->count()) {
            $res['code'] = "200";
            $res['data'] = $actives;
        }else{
            $res['code'] = "400";
            $res['data'] = "暂无数据";
            return json_encode($res);
        }
        return json_encode($res);
    }

    public function setting()
    {
        $res = [];
        $settings = Setting::all();
        $res['code'] = "200";
        $res['data'] = $settings;
        return json_encode($res);
    }

    public function test(TestRepository $testRepository)
    {
        $testRepository->data();
    }
}
