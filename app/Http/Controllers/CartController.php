<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function cart(){
        $g_id = request()->input('g_id','');
        $g_num = request()->input('g_num','');
        if ($g_id==''){
            echo json_encode(['font'=>'请选择一商品','code'=>2]);die;
        }
        $num = DB::table('shop_goods')->where('g_id',$g_id)->value('g_num');
        if ($g_num>$num){
            echo json_encode(['font'=>'超出库存','code'=>2]);die;
        }
        $user = request()->session()->get('userInfo');
        if (!$user){
            echo json_encode(['font'=>'请登录','code'=>2]);die;
        }
        $data = [
            'g_id'=>$g_id,
            'u_id'=>$user['u_id'],
            'car_num'=>$g_num,
            'create_time'=>time(),
            'update_time'=>time()
        ];
        $where = [
            'g_id'=>$g_id,
            'u_id'=>$user['u_id'],
            'is_del'=>1
        ];
        $cart = DB::table('shop_cart')->where($where)->first();
        if ($cart){
            $cart->car_num = $g_num+$cart->car_num;
            if ($cart->car_num>$num){
                echo json_encode(['font'=>'超出库存','code'=>2]);die;
            }
            $cart = json_encode($cart);
            $cart = json_decode($cart,true);
            $res = DB::table('shop_cart')->where('car_id',$cart['car_id'])->update($cart);
            if ($res){
                echo json_encode(['font'=>'放入购物车成功','code'=>1]);die;
            }else{
                echo json_encode(['font'=>'放入购物车失败','code'=>2]);die;
            }
        }else{
            $res = DB::table('shop_cart')->insert($data);
            if ($res){
                echo json_encode(['font'=>'放入购物车成功','code'=>1]);
            }else{
                echo json_encode(['font'=>'放入购物车失败','code'=>2]);die;
            }
        }
    }
    public function index(){
        $cartInfo = DB::table('shop_cart as c')
            ->join('shop_goods as g', 'c.g_id', '=', 'g.g_id')
            ->where('c.is_del',1)
            ->select('c.car_num','c.g_id','c.create_time','g_num', 'g.g_name', 'g.g_price')
            ->get();
        $count = count($cartInfo);
        $address = DB::table('shop_address')->where('is_del',1)->get();
        return view('CartController.index',compact('cartInfo','count','address'));
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
    public function money(){
        $g_id = request()->input('g_id');
        $g_id = explode(',',$g_id);
        if (empty($g_id)){
            echo 0;
        }
        $moneyAll = $this->moneyAll($g_id);
        echo $moneyAll;
    }
    public function moneyAll($g_id){
        $sess = request()->session()->get('userInfo');
        $where['c.is_del'] = 1;
        $where['c.u_id'] = $sess['u_id'];
        //两表查询  alias别名
        $goods =DB::table('shop_cart as c')
            ->join('shop_goods as g', 'c.g_id', '=', 'g.g_id')
            ->where($where)
            ->whereIn('c.g_id',$g_id)->select('c.car_num','g.g_price')
            ->get();
        $count=0;
        foreach ($goods as $k => $v) {
            $count+=$v->car_num*$v->g_price;
        }
        return $count;
    }
    public function countTotal(){
        $g_id = request()->input('g_id');
        $g_id = explode(',',$g_id);
        if (empty($g_id)) {
            echo 0;
        }
        $money = $this->moneyAll($g_id);
        echo $money;
    }
    public function changeCartNum(){
        $g_id = request()->input('g_id','');
        $car_num = request()->input('car_num','');
        $sess = request()->session()->get('userInfo');
        //检测库存
        $num = DB::table('shop_goods')->where('g_id',$g_id)->value('g_num');
        if ($car_num>$num) {
            echo json_encode(['font'=>'超出库存','code'=>2]);
        }else{
            $where = [
                'g_id'=>$g_id,
                'u_id'=>$sess['u_id']
            ];
            $update = [
                'car_num'=>$car_num,
                'update_time'=>time()
            ];
            $res = DB::table('shop_cart')->where($where)->update($update);
            if ($res) {
                echo json_encode(['font'=>'修改成功','code'=>1]);
            }else{
                echo json_encode(['font'=>'修改失败','code'=>2]);
            }
        }
    }
    public function order(){
        $g_id = request()->input('g_id','');
        $g_id = explode(',',$g_id);
        $sess = request()->session()->get('userInfo');
        $moneyAll = $this->moneyAll($g_id);
        $cartInfo = DB::table('shop_cart as c')
            ->join('shop_goods as g', 'c.g_id', '=', 'g.g_id')
            ->where('c.is_del',1)
            ->whereIn('c.g_id',$g_id)
            ->select('c.car_num','c.g_id','c.create_time','g_num', 'g.g_name', 'g.g_price')
            ->get();
        $count = count($cartInfo);
        $where = [
            'is_del'=>1,
            'u_id'=>$sess['u_id']
        ];
        $address = DB::table('shop_address')->where($where)->get();
        $g_id = implode(',',$g_id);
        return view('CartController.close',compact('cartInfo','count','g_id','address','moneyAll'));
    }
    public function orderForm(){
        DB::beginTransaction();
        $g_id = request()->input('g_id','');
        $add_id = request()->input('add_id','');
        $pay_type = request()->input('pay_type','');
        $sess = request()->session()->get('userInfo');
        if ($g_id==''){
            echo json_encode(['font'=>'请选择商品','code'=>2]);
            die;
        }
        if ($add_id==''){
            echo json_encode(['font'=>'请选择收货地址','code'=>2]);
            die;
        }
        $address = DB::table('shop_address')->where('add_id',$add_id)->first();
        $g_id = explode(',',$g_id);
        $moneyAll = $this->moneyAll($g_id);
        $order = [
            'o_no'=>time().rand(100000,999999).$sess['u_id'],
            'o_amount'=>$moneyAll,
            'pay_type'=>$pay_type,
            'create_time'=>time(),
            'u_id'=>$sess['u_id']
        ];
        $o_id = DB::table('shop_order')->insertGetId($order);
        $goodsInfo = DB::table('shop_cart as c')
            ->join('shop_goods as g', 'c.g_id', '=', 'g.g_id')
            ->where('c.is_del',1)
            ->whereIn('c.g_id',$g_id)
            ->select('c.car_num','c.g_id','g_num', 'g.g_name', 'g.g_price')
            ->get();
        $goods = [];
        foreach ($goodsInfo as $v){
            $goods[] =[
                'g_num'=>$v->car_num,
                'g_id'=>$v->g_id,
                'g_name'=>$v->g_name,
                'g_price'=>$v->g_price,
                'create_time'=>time(),
                'u_id'=>$sess['u_id'],
                'o_id'=>$o_id
            ];
        }
        $goodsRes = DB::table('shop_order_detail')->insert($goods);
        $update = ['is_del'=>2];
        $cartDel = DB::table('shop_cart')->where('is_del',1)->update($update);
        if ($o_id&&$goodsRes&&$cartDel){
            DB::commit();
            echo json_encode(['font'=>'下单成功','code'=>1,'o_id'=>$o_id]);
        }else{
            echo json_encode(['font'=>'下单失败','code'=>2]);
            DB::rollBack();
        }
    }
}
