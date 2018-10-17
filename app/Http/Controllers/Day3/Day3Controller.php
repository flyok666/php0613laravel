<?php

namespace App\Http\Controllers\Day3;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Day3Controller extends Controller
{
    //session的操作
    public function session(Request $request)
    {
        
        //获取session实例，两种方法
        //$request->session();
        //session();
        //操作session
        //$request->session()->put('name','张三');
        //session(['age'=>20]);
        //获取
        //$name = session('name');
//        $name = session()->get('name2');
        //$name = session('name2','');
        /*$age = session()->get('age2',function(){
            return 10;
        });*/
        session()->forget('age');
        $age = session('age');
        dd($age);
    }
    //响应
    public function response()
    {
        //return ['a'=>1,'b','c'];
        //$admin = Admin::find(1);
        //$admins = Admin::all();
        //return $admins;
        //数组或对象 转 json字符串
        //json_encode();
        //json字符串转 数组或对象
        //json_decode();

        //cookie
        return response('hello')->cookie('sex','nan',10);
    }
}
