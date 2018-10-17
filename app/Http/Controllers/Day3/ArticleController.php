<?php

namespace App\Http\Controllers\Day3;

use App\Models\Admin;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    public function __construct()
    {
        //配置auth中间件 对需要登录才能访问的方法做权限验证
        $this->middleware('auth',[
            //除了哪些方法外 生效
            'except'=>['index'],
            //只对哪些方法生效
            //'only'=>[]
        ]);
    }

    //列表
    public function index()
    {
        /*if(Auth::user()==null){
            return redirect()->route('login')->with('warning','请先登录');
        }*/
        $articles = Article::paginate(2);

        return view('article.list',compact('articles'));
    }
    //添加
    public function create()
    {
        //获取所有作者
        $admins = Admin::all();
        return view('article.add',compact('admins'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'title'=>'required',
            'content'=>'required',
            'author_id'=>'required',
            'publish_date'=>'required',
            'captcha'=>'required|captcha',
            'cover'=>'required|file',
        ]);
        //验证失败
        //return back()->withInput();
        //处理上传文件
        $path = $request->file('cover')->store('public/articles');

        Article::create([
            'title'=>$request->title,
            'content'=>$request->input('content'),
            'author_id'=>$request->author_id,
            'publish_date'=>$request->publish_date,
            'cover'=>$path
        ]);

        //session()->flash('success','文章添加成功');

        return redirect()->route('articles.index')->with('success','添加成功');
    }
    //修改
    public function edit(Article $article)
    {
        //只能修改自己的文章
        /*if($article->author_id != Auth::user()->id){
            return response('不能 修改别人的文章',403);
        }*/
        $this->authorize('update',$article);

        $admins = Admin::all();
        return view('article.edit',compact('article','admins'));
    }

    public function update(Article $article,Request $request)
    {
        $this->authorize('update',$article);
        $this->validate($request,[
            'title'=>'required',
            'content'=>'required',
            'author_id'=>'required',
            'publish_date'=>'required',
        ]);

        $article->update([
            'title'=>$request->title,
            'content'=>$request->input('content'),
            'author_id'=>$request->author_id,
            'publish_date'=>$request->publish_date,
        ]);

        session()->flash('success','文章修改成功');

        return redirect()->route('articles.index');
    }
    //删除
    public function destroy(Article $article)
    {
        $article->delete();
        session()->flash('success','文章删除成功');

        return redirect()->route('articles.index');
    }
    //查看
    public function show()
    {
        
    }
}
