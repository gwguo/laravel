<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Memcache;

class GoodsController extends Controller
{
    public function index()
    {
        $id = request()->input('g_id','');
        if ($id==''){
            return redirect('/list');
        }
        $goods = DB::table('shop_goods')->where('g_id',$id)->first();
        return view('/GoodsController.index',compact('goods'));
    }
//    public function goods(){
//        $memcache = new Memcache;
//        $res = $memcache->connect('127.0.0.1',11211);
//        $goods = $memcache->get('goods');
//        if (!$goods){
//            $con = mysqli_connect('127.0.0.1','root','root','shop');
//            $sql = "select * from shop_goods where g_up=1";
//            $goods = mysqli_query($con,$sql);
//            $goods = mysqli_fetch_all($goods,1);
//            $memcache->set('goods',$goods);
//        }
//        dd($goods);
//    }
}
