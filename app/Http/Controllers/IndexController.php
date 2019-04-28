<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
class IndexController extends Controller
{
    public function homePage(){
        $query = request()->all();
        $g_name = request()->input('g_name','');
        $where['g_hot'] = 1;
        if ($g_name!=''){
            $where[] = ['g_name','like',"%$g_name%"];
        }
        //获取全部商品信息
        $goods = DB::table('shop_goods')->where($where)->get();
        //获取品牌
        $cate = DB::table('shop_category')->where('pid',0)->get();
        $count = DB::table('shop_goods')->count();
        return view('IndexController.homePage',compact('goods','count','cate','query'));
    }
    public function index(){
        $query = request()->all();
        $g_name = request()->input('g_name','');
        $c_id = request()->input('c_id','');
        $where['g_up'] = 1;
        if ($g_name!=''){
            $where[] = ['g_name','like',"%$g_name%"];
        }
        if ($c_id!=''){
            $cate = $goods = DB::table('shop_category')->where('c_show',1)->get();
            $id = $this->floorCate($cate,$c_id);
            $goods = DB::table('shop_goods')->where($where)->whereIn('c_id',$id)->get();
        }else{
            $goods = DB::table('shop_goods')->where($where)->get();
        }
        return view('IndexController/index',compact('goods','query','g_name'));
    }
    public function lists(){
        $field = request()->input('field','');
        $type = request()->input('type','');
        $goods = DB::table('shop_goods')->where('g_up',1)->orderBy($field,$type)->get();
        echo view('GoodsController/div',compact('goods'));
    }
    public function floorCate($info,$c_id){
        static $id = [];
        foreach ($info as $k => $v) {
            if ($v->pid==$c_id) {
                $id[] = $v->c_id;
                $this->floorCate($info,$v->c_id);
            }
        }
        return $id;
    }
    public function collect(){
        $u_id = request()->session()->get('userInfo')['u_id'];
        $data = DB::table('shop_collect')->where('u_id',$u_id)->get();
        $g_id = [];
        foreach ($data as $v){
            $g_id[] = $v->g_id;
        }
        $goods = DB::table('shop_goods')->where('g_up',1)->whereIn('g_id',$g_id)->get();
        $count = count($goods);
        return view('IndexController.collect',compact('goods','count'));
    }
    public function quxiao(){
        $g_id = request()->input('g_id');
        $res = DB::table('shop_collect')->where('g_id',$g_id)->delete();
        if ($res){
            echo json_encode(['font'=>'取消成功','code'=>1]);
        }else{
            echo json_encode(['font'=>'取消失败','code'=>2]);
        }
    }
}
