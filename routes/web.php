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

//Route::get('/', function () {
//    return view('welcome');
//});
//Route::get('/hello',function(){
//    return '<form method="post" action="aaa">'.csrf_field().'
//            <input type="text" name="abc">
//             <input type="submit" value="提交">
//            </form>';
//});
//Route::post('/aaa/{name?}',function($name=null){
//    echo $name;
//    dd(request()->input());
//});
//设置路由
//Route::get('/login','BlogrollController@login');
//Route::post('BlogrollController/loginDo','BlogrollController@loginDo');
//Route::prefix('UserController')->middleware('user')->group(function(){
//    Route::get('/add','UserController@add');
//    Route::get('/aa','UserController@aa');
//    Route::post('/adddo','UserController@adddo');
//    Route::get('/index','UserController@index');
//    //给路由设置一名字  必填参数
//    Route::get('/del/{id}','UserController@del')->name('delUser');
//    Route::get('/edit/{id}','UserController@edit');
//    Route::post('/update','UserController@update');
//    Route::post('/checkName','UserController@checkName');
//});
//Route::prefix('BlogrollController')->middleware('user')->group(function(){
//    Route::get('/add','BlogrollController@add');
//    Route::get('/aa','BlogrollController@aa');
//    Route::post('/adddo','BlogrollController@adddo');
//    Route::get('/index','BlogrollController@index');
//    //给路由设置一名字  必填参数
//    Route::get('/del/{id}','BlogrollController@del')->name('del');
//    Route::get('/edit/{id}','BlogrollController@edit');
//    Route::post('/editdo','BlogrollController@editdo');
//    Route::post('/checkName','BlogrollController@checkName');
//});
////登录注册
//Auth::routes();
//Route::get('/home', 'HomeController@index')->name('home');
////商品注册登录
//Route::get('/register','LogController@register');
//Route::get('/log','LogController@log');
//Route::prefix('/log')->group(function(){
//    Route::post('/checkEmail','logController@checkEmail');
//    Route::post('/sendEmail','logController@sendEmail');
//    Route::post('/sendPhone','logController@sendPhone');
//    Route::post('/registerDo','logController@registerDo');
//    Route::post('/login','logController@login');
//});
////商品首页  显示品牌
//Route::get('/','IndexController@index');
//Route::get('/goods','GoodsController@index');
//登录 注册
Route::get('/','IndexController@homePage');
Route::get('/register','LogController@register');
Route::get('/log','LogController@log');
Route::prefix('/log')->group(function(){
    Route::post('/checkEmail','logController@checkEmail');
    Route::post('/sendEmail','logController@sendEmail');
    Route::post('/sendPhone','logController@sendPhone');
    Route::post('/registerDo','logController@registerDo');
    Route::post('/login','logController@login');
    Route::get('/out','logController@out');
});
//商品信息
Route::get('/list','IndexController@index');
Route::post('/lists','IndexController@lists');
Route::get('/goods','GoodsController@index');
Route::get('/user','UserController@index');
Route::get('/address','AddressController@add');
Route::prefix('/address')->group(function(){
    Route::get('/add','AddressController@add');
    Route::post('/city','AddressController@city');
    Route::post('/adddo','AddressController@adddo');
    Route::get('/index','AddressController@index');
});
Route::post('/cart','CartController@cart');
Route::prefix('/cart')->group(function(){
    Route::get('/index','CartController@index');
    Route::post('/money','CartController@money');
    Route::post('/countTotal','CartController@countTotal');
    Route::post('/changeCartNum','CartController@changeCartNum');
    Route::get('/order','CartController@order');
    Route::post('/orderForm','CartController@orderForm');
});
Route::get('/pay','PayController@payment');
Route::get('/successPay','PayController@successPay');
Route::get('/collect','IndexController@collect');
Route::get('/quxiao','IndexController@quxiao');

//Route::get('/reg','KloginController@reg');
//Route::get('/Klog','KloginController@Klog');
//Route::get('/Kuser','KloginController@Kuser');
//Route::post('/sendEmail','KloginController@sendEmail');
//Route::post('/zc','KloginController@zc');
//Route::post('/Klondo','KloginController@Klondo');



