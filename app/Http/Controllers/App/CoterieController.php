<?php

namespace App\Http\Controllers\App;

use App\Models\Comment;
use App\Models\Coterie;
use App\Models\Like;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CoterieController extends Controller
{
    /**
     * get Coterie
     *
     * @return json
     */
    public function index(Request $request)
    {
        $res = [];
        $coteries = Coterie::where('user_id',$request->user()->id)->paginate(6);
        if ($coteries->count()) {
            # code...
            foreach ($coteries as $coterie){
                $coterie['comments'] = Comment::where(['cate_id'=>'2','pid'=>$coterie->id])->select('user_id','comment_text')->get()->each(function ($item,$key){
                    $item->user;
                });
                $coterie['likes'] = Like::where(['is_like'=>'0','cate_id'=>'2','pid'=>$coterie->id])->select('user_id')->get()->each(function ($item,$key){
                    $item->user;
                });
            }
            $res['code'] = "200";
            $res['data'] = $coteries;
        }else{
            $res['code'] = "400";
            $res['data'] = "暂无数据";
            return json_encode($res);
        }
        return json_encode($res);
    }

    public function othersCoterie(Request $request)
    {
        $res = [];
        $coteries = Coterie::where('user_id',$request->get('id'))->paginate(6);
        if ($coteries->count()) {
            # code...
            foreach ($coteries as $coterie){
                $coterie['comments'] = Comment::where(['cate_id'=>'2','pid'=>$coterie->id])->select('user_id','comment_text')->get()->each(function ($item,$key){
                    $item->user;
                });
                $coterie['likes'] = Like::where(['is_like'=>'0','cate_id'=>'2','pid'=>$coterie->id])->select('user_id')->get()->each(function ($item,$key){
                    $item->user;
                });
            }
            $res['code'] = "200";
            $res['user'] = User::find($request->get('id'));
            $res['data'] = $coteries;
        }else{
            $res['code'] = "400";
            $res['data'] = "暂无数据";
            return json_encode($res);
        }
        return json_encode($res);
    }

    /**
     * publish Coterie
     *
     *
     */
    public function publish(Request $request)
    {
        $res = [];
        $coterie = new Coterie;
        $coterie->user_id = $request->user()->id;
        $coterie->coterie_text = $request->get('text');
        $coterie->coterie_pics = $request->get('pics');
        $saved = $coterie->save();
        if ($saved) {
            # code...
            $res['code'] = "200";
            $res['data'] = "保存成功";
        }else{
            $res['code'] = "400";
            $res['data'] = "保存失败";
            return json_encode($res);
        }
        return json_encode($res);
    }

    public function delete(Request $request)
    {
        $res = [];
        $delete = Coterie::destroy($request->get('id'));
        if ($delete){
            $res['code'] = "200";
            $res['data'] = "删除成功";
        }else{
            $res['code'] = "400";
            $res['data'] = "删除失败";
            return json_encode($res);
        }
        return json_encode($res);
    }

    public function comment(Request $request)
    {
        $res = [];
        $comment = new Comment;
        $comment->user_id = $request->user()->id;
        $comment->cate_id = "2";
        $comment->pid = $request->get('id');
        $comment->comment_text = $request->get('text');
        $saved = $comment->save();
        if ($saved) {
            # code...
            $res['code'] = "200";
            $res['data'] = "保存成功";
        }else{
            $res['code'] = "400";
            $res['data'] = "保存失败";
            return json_encode($res);
        }
        return json_encode($res);
    }

    public function like(Request $request)
    {
        $res = [];
        $likes = Like::firstOrCreate(['user_id' => $request->user()->id , 'cate_id' => '2' , 'pid' => $request->get('id')]);
        if ($likes->count()) {
            if ($likes->is_like == '0'){
                $likes->update(['is_like' => 1]);
                $res['code'] = "200";
                $res['data'] = "取消点赞成功";
            }else{
                $likes->update(['is_like' => 0]);
                $res['code'] = "200";
                $res['data'] = "点赞成功";
            }

        }else{
            $res['code'] = "400";
            $res['data'] = "点赞失败";
            return json_encode($res);
        }
        return json_encode($res);
    }

}
