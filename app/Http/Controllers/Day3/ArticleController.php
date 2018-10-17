<?php

namespace App\Http\Controllers\Day3;

use App\Models\Admin;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    //列表
    public function index()
    {
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
        $admins = Admin::all();
        return view('article.edit',compact('article','admins'));
    }

    public function update(Article $article,Request $request)
    {
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
