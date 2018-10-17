<?php

namespace App\Http\Controllers\Day4;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class UserController extends Controller
{
    //用户注册
    public function create()
    {
        $user = new User();
        $user->name = 'zhangsan';
        $user->email = 'zhangsan@qq.com';
        $user->password = bcrypt('123456');//密码加密
        $user->remember_token = str_random(50);//跟自动登录功能相关 随机字符串
        $user->save();

    }
    //用户首页
    public function index()
    {
        $route = Route::current();
        dump($route);//uri 当前路由请求

        $name = Route::currentRouteName();
        dump($name);
        $action = Route::currentRouteAction();
        dump($action);

        //获取已登录用户的信息
        $user = Auth::user();

        return view('session.index',['user'=>$user]);
    }

    public function test($x,$y)
    {
        return $x.$y;
    }
}
