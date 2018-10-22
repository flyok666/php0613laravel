<?php

namespace App\Http\Controllers\Lianxi;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //增删改查
    //一、 创建模型和数据迁移
    //二、 修改并执行数据迁移，创建模型对应的数据表
    //三、 添加资源路由
    //四、 创建控制器
    //4.1 添加
    // 两个方法create():展示添加表单
    // 添加表单视图（确保定义csrf验证字段）
    //   store()：验证并保存数据
    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        //数据验证
        $this->validate($request,[
            'username'=>'required',
            'password'=>'required',
            'email'=>'required',
            'sex'=>'required',
        ],[
            'username.required'=>'用户名不能为空',
        ]);
        //验证通过，保存数据到数据表(前提：确保模型中已定义可以赋值的属性$fillable;)
        Admin::create([
            'username'=>$request->username,
            'password'=>bcrypt($request->password),//保存时 密码要加密
            'email'=>$request->email,
            'sex'=>$request->sex,
        ]);

        //提示信息加跳转
        return redirect()->route('admins.index')->with('success','用户添加成功');
    }

    //4.2列表
    public function index()
    {
        $admins = Admin::paginate(10);

        return view('admin.index',compact('admins'));

    }
    //4.3修改
    //edit():显示修改表单(请求方式是PUT)，回显要修改的数据
    //update():验证并更新数据
    public function edit(Admin $admin){//参数名称和路由中的参数名称一致
        return view('admin.edit',compact('admin'));
    }

    public function update(Admin $admin,Request $request)
    {
        //数据验证
        $this->validate($request,[
            'username'=>'required',
            'email'=>'required',
            'sex'=>'required',
        ],[
            'username.required'=>'用户名不能为空',
        ]);
        //验证通过，更新数据到数据表(前提：确保模型中已定义可以赋值的属性$fillable;)
        $admin->update([
            'username'=>$request->username,
            //'password'=>bcrypt($request->password),//保存时 密码要加密
            'email'=>$request->email,
            'sex'=>$request->sex,
        ]);

        //提示信息加跳转
        return redirect()->route('admins.index')->with('success','用户修改成功');
    }

    //删除
    public function destroy(Admin $admin)
    {
        $admin->delete();
        return 'success';
    }

    //登录
    //1、准备好登录认证需要的模型
    //2、修改auth配置，修改认证模型
    public function login()
    {
        return view('admin.login');
    }

    public function check(Request $request)
    {
        $this->validate($request,[
            'username'=>'required',
            'password'=>'required',
        ],[
            'username.required'=>'用户名不能为空',
        ]);
        //验证登录信息，并保存用户状态
        if(Auth::attempt(['username'=>$request->username,'password'=>$request->password])){
            //认证通过，登录成功
            return redirect()->intended(route('admins.index'));
        }else{
            //认证失败
            return back()->withInput();
        }
    }
    //注销
    public function logout()
    {
        Auth::logout();
        return redirect()->route('admins.login');
    }

    /*public function show()
    {
        
    }*/

}
