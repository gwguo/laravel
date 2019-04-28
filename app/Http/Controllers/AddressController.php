<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function add(){
        $probince = $this->area(0);
        return view('AddressController.add',compact('probince'));
    }
    public function adddo(){
        $data = request()->all();
        $sess = request()->session()->get('userInfo');
        $data['u_id'] = $sess['u_id'];
        if (!$sess){
            echo json_encode(['font'=>'请登录后在填写收货地址','code'=>2]);
        }
        $count = DB::table('shop_address')->where('add_name',$data['add_name'])->count();
        if ($count>0){
            echo json_encode(['font'=>'用户已存在','code'=>2]);
            die;
        }
//        dd($data);
        $update = DB::table('shop_address')->where('u_id',$sess['u_id'])->update(['add_exist'=>2]);
        $res = DB::table('shop_address')->insert($data);
        if ($res){
            echo json_encode(['font'=>'保存成功','code'=>1]);
        }else{
            echo json_encode(['font'=>'保存失败','code'=>2]);
        }
    }
    public function index(){
        $sess = session('userInfo');
        $where = [
            'is_del'=>1,
            'u_id'=>$sess['u_id']
        ];
        $address = DB::table('shop_address')->where($where)->get();
        return view('AddressController.index',compact('address'));
    }
    public function city(){
        $id = request()->input('id');
        $city = $this->area($id);
        echo json_encode($city);
    }
    //获取城市信息
    public function area($id){
        $city = DB::table('shop_area')->where('pid',$id)->get()->toArray();
//        dd($city);
        return $city;
    }
}
