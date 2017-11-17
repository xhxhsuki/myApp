<?php

namespace App\Http\Controllers\App;

use App\Models\Blog;
use App\Models\Blogfavorite;
use App\Models\Comment;
use App\Models\Coterie;
use App\Models\Like;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    /**
     * get Coterie
     *
     * @return json
     */
    public function index(Request $request)
    {
        $res = [];
        $blogs = Blog::where(['model_id'=>$request->get('model')])->paginate(6);
        foreach ($blogs as $blog){
            $blog['user'] = $blog->user;
            $blog['comments'] = Comment::where(['cate_id'=>'3','pid'=>$blog->id])->count();
        }
        if ($blogs->count()) {
            $res['code'] = "200";
            $res['data'] = $blogs;
        }else{
            $res['code'] = "400";
            $res['data'] = "暂无数据";
            return json_encode($res);
        }
        return json_encode($res);
    }

    public function search(Request $request)
    {
        $res = [];
        $blogs = Blog::where(['model_id'=>$request->get('model')])->where('blog_title','like',"%".$request->get('text')."%")->paginate(6);
        foreach ($blogs as $blog){
            $blog['user'] = $blog->user;
            $blog['comments'] = Comment::where(['cate_id'=>'3','pid'=>$blog->id])->count();
        }
        if ($blogs->count()) {
            $res['code'] = "200";
            $res['data'] = $blogs;
        }else{
            $res['code'] = "400";
            $res['data'] = "暂无数据";
            return json_encode($res);
        }
        return json_encode($res);
    }

    public function detail(Request $request)
    {
        $res = [];
        $blog = Blog::find($request->get('id'));
        if ($blog->count()) {
            $blog->user;
            $blog['comments'] = Comment::where(['cate_id'=>'3','pid'=>$blog->id])->select('id','user_id','comment_text','updated_at')->get()->each(function ($item,$key){
                $item->user;
                $item['likes'] = Like::where(['is_like'=>'0','cate_id'=>'3','pid'=>$item->id])->count();
            });
            $favorite = Blogfavorite::where(['blog_id'=>$request->get('id'),'user_id'=>$request->user()->id])->get();
            if ($favorite->count()){
                if ($favorite->first()->is_favorite == "0"){
                    $blog['is_favorite'] = "0";
                }else{
                    $blog['is_favorite'] = "1";
                }
            }else{
                $blog['is_favorite'] = "1";
            }
            $res['code'] = "200";
            $res['data'] = $blog;
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
     * @return json
     */
    public function publish(Request $request)
    {
        $res = [];
        $blog = new Blog;
        $blog->user_id = $request->user()->id;
        $blog->model_id = $request->get('model');
        $blog->blog_title = $request->get('title');
        $blog->blog_text = $request->get('text');
        $blog->blog_pics = $request->get('pics');
        $saved = $blog->save();
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
        $delete = Comment::destroy($request->get('id'));
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
        $comment->cate_id = "3";
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

    public function myComments(Request $request)
    {
        $res = [];
        $comments = Comment::where(['user_id'=>$request->user()->id,'cate_id'=>'3'])->select('id','pid','comment_text')->paginate(10);
        foreach ($comments as $comment){
            $comment['blogtitle'] = Blog::where('id',$comment->pid)->first()->blog_title;
        }
        if ($comments->count()) {
            # code...
            $res['code'] = "200";
            $res['data'] = $comments;
        }else{
            $res['code'] = "400";
            $res['data'] = "暂无数据";
            return json_encode($res);
        }
        return json_encode($res);
    }

    public function myFavorites(Request $request)
    {
        $res = [];
        $favorites = Blogfavorite::where(['user_id'=>$request->user()->id,'is_favorite'=>'0'])->paginate(10);
        foreach ($favorites as $favorite){
            $favorite['blog'] = Blog::where('id',$favorite->blog_id)->select('id','blog_title','blog_text','blog_pics')->get();
        }
        if ($favorites->count()) {
            # code...
            $res['code'] = "200";
            $res['data'] = $favorites;
        }else{
            $res['code'] = "400";
            $res['data'] = "暂无数据";
            return json_encode($res);
        }
        return json_encode($res);
    }

    public function like(Request $request)
    {
        $res = [];
        $likes = Like::firstOrCreate(['user_id' => $request->user()->id , 'cate_id' => '3' , 'pid' => $request->get('id')]);
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

    public function favorite(Request $request)
    {
        $res = [];
        $favorites = Blogfavorite::firstOrCreate(['user_id' => $request->user()->id ,'blog_id' => $request->get('id')]);
        if ($favorites->count()) {
            if ($favorites->is_favorite == '0'){
                $favorites->update(['is_favorite' => 1]);
                $res['code'] = "200";
                $res['data'] = "取消收藏成功";
            }else{
                $favorites->update(['is_favorite' => 0]);
                $res['code'] = "200";
                $res['data'] = "收藏成功";
            }

        }else{
            $res['code'] = "400";
            $res['data'] = "点赞失败";
            return json_encode($res);
        }
        return json_encode($res);
    }

}
