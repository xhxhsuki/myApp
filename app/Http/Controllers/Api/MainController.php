<?php
/**
 * Created by PhpStorm.
 * User: xhxhs
 * Date: 2017/10/30
 * Time: 14:56
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Active;
use App\Models\Comment;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Storecategory;
use App\Models\Store;
use App\Repositories\TestRepository;
use Illuminate\Http\Request;
use App\Models\Article;

class MainController extends Controller
{
    public function index()
    {
        return "111";
    }

    public function articlelist()
    {
        $res = [];
        $articles = Article::where('article_is_public','0')->orderBy('created_at','desc')->select('id','article_title','article_description','article_pic')->paginate(10);
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
        $article = Article::where('id',$request->get('id'))->first();
        if ($article) {
            $res['code'] = "200";
            $res['data'] = $article;
        }else{
            $res['code'] = "404";
            $res['data'] = "暂无数据";
            return json_encode($res);
        }
        return json_encode($res);
    }

    public function storecategory()
    {
        $res = [];
        $storecates = Storecategory::where('cate_is_public','0')->orderBy('cate_order','desc')->select('id','cate_name','cate_pic')->get();
        if ($storecates->count()) {
            $res['code'] = "200";
            $res['data'] = $storecates;
        }else{
            $res['code'] = "400";
            $res['data'] = "暂无数据";
            return json_encode($res);
        }
        return json_encode($res);
    }

    public function activelist()
    {
        $res = [];
        $actives = Active::where('active_is_public','0')->orderBy('active_order','desc')->select('id','active_title','active_pic','active_store_id')->paginate(10);
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

    public function storelist(Request $request)
    {
        $res = [];
        $stores = Store::where(['store_is_public'=>'0','category_id'=>$request->get('cate')])->orderBy('created_at','desc')->select('id','store_title','store_sliders','store_description','store_position','store_address')->paginate(10);
        if ($stores->count()) {
            $res['code'] = "200";
            $res['data'] = $stores;
        }else{
            $res['code'] = "400";
            $res['data'] = "暂无数据";
            return json_encode($res);
        }
        return json_encode($res);
    }

    public function store(Request $request)
    {
        $res = [];
        $store = Store::where(['store_is_public'=>'0','id'=>$request->get('id')])->get();
        $comments = Comment::where(['cate_id'=>'1','pid'=>$request->get('id')])->select('id','user_id','comment_text','created_at')->get();
        $products = Product::where(['product_is_public'=>'0','store_id'=>$request->get('id')])->select('id','product_name','product_pics','product_origin_price','product_price')->get();
        if ($store->count()) {
            $res['code'] = "200";
            $res['data'] = $store->first();
            $res['comments'] = $comments;
            $res['products'] = $products;
        }else{
            $res['code'] = "400";
            $res['data'] = "暂无数据";
            return json_encode($res);
        }
        return json_encode($res);
    }

    public function product(Request $request)
    {
        $res = [];
        $product = Product::where(['product_is_public'=>'0','id'=>$request->get('id')])->first();
        if ($product) {
            $res['code'] = "200";
            $res['data'] = $product;
        }else{
            $res['code'] = "404";
            $res['data'] = "暂无数据";
            return json_encode($res);
        }
        return json_encode($res);
    }

    public function sliders(Request $request)
    {
        $res = [];
        $sliders = Slider::where('slider_is_public','0')->select('id','pic','url')->get();
        if ($sliders) {
            $res['code'] = "200";
            $res['data'] = $sliders;
        }else{
            $res['code'] = "404";
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
