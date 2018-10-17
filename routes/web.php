<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
//定义三个路由  首页  关于 帮助
Route::get('/index','HomeController@index');  // index-->HomeController->index()
Route::get('/about','HomeController@about');

//添加学生
Route::get('/student/add','StudentController@add')->name('student.add');
Route::post('/student/save','StudentController@save');
//学生列表
Route::get('student/index','StudentController@index')->name('student.index');

//测试
Route::get('test','BookController@test');

//添加用户
Route::get('/user/add','Day2\AdminController@add')->name('user.add');
Route::post('/user/save','Day2\AdminController@save')->name('user.save');


Route::get('/user/test','Day2\AdminController@test')->name('user.test');
Route::get('/user/list','Day2\AdminController@list')->name('user.list');
//修改用户
Route::get('/user/edit/{admin}','Day2\AdminController@edit')->name('user.edit');
Route::post('/user/update/{admin}','Day2\AdminController@update')->name('user.update');
//删除用户
Route::get('/user/delete/{admin}','Day2\AdminController@delete')->name('user.delete');

//数据表操作
Route::get('/db','Day2\DbController@index');

//资源路由 （文章）
/*Route::get('/articles/{article}/edit',function(\App\Models\Article $article){
    dd($article->title);
});*/
//Route::resource('articles','Day3\ArticleController');

/*//添加
Route::get('articles/create','Day3\ArticleController@create')->name('articles.create');
Route::post('articles','Day3\ArticleController@store')->name('articles.store');
//修改
Route::get('articles/{article}/edit','Day3\ArticleController@edit')->name('articles.edit');
Route::put('articles/{article}','Day3\ArticleController@update')->name('articles.update');
//获取所有文章
Route::get('articles','Day3\ArticleController@index')->name('articles.index');
//查看一篇文章
Route::get('articles/{article}','Day3\ArticleController@show')->name('articles.show');
//删除文章
Route::delete('articles/{article}','Day3\ArticleController@destroy')->name('articles.destroy');*/

//session
Route::get('session','Day3\Day3Controller@session');
Route::get('response','Day3\Day3Controller@response');
//Route::get('response',function(){
//    return 'world';
//});
//Route::get('user/index','Day4\UserController@index');

Route::namespace('Day4')->group(function(){
    Route::prefix('user')->group(function(){
        //注册用户
        Route::get('register','UserController@create');
        Route::get('index','UserController@index')->name('user.index');
    });


//用户登录
    Route::get('login','SessionController@create')->name('login');
    Route::post('login','SessionController@store')->name('login');
//注销
    Route::get('logout','SessionController@destroy')->name('logout');
});


//路由详解
/*Route::get('route',function(){
    return ['name'=>'张三'];
});*/
// put patch
//Route::match(['put','patch'],'login','Day4\SessionController@create')->name('login');
/*Route::any('/',function(){
    return '首页';
});*/
//Route::redirect('/admin/login','/login',301);
//Route::view('/index','session.create');
//Route::get('/index/{a}/{b?}',function($x,$y=null){
//    return $x.$y;
//})->where('a','\d+');
//Route::get('/index/{a}/{b}','Day4\UserController@test');

//下面两个路由都需要登录认证
/*Route::middleware(['auth'])->group(function(){
    Route::resource('users','UsersController');
    Route::resource('book','BooksController');
});*/

//发送邮件
Route::get('/mail',function(){
    $name = 'lk';
    $flag = \Illuminate\Support\Facades\Mail::send('mail',['name'=>$name],function($message){
        $to = '1256268139@qq.com';
        $message->to($to)->subject('阿里云数据库10月刊:Redis发布');
    });
    dd($flag);
    /*if($flag){
        echo '发送邮件成功，请查收！';
    }else{
        echo '发送邮件失败，请重试！';
    }*/
});

//redis
Route::get('/redis',function(){
//    \Illuminate\Support\Facades\Redis::set('name','赵云');
    return \Illuminate\Support\Facades\Redis::get('name');
});