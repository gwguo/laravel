<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use \Log;

class PayController extends Controller
{
    //电脑版
//    public function payment(){
//        $o_id = request()->input('o_id');
//        $order = DB::table('shop_order')->where('o_id',$o_id)->first();
//        $goods = DB::table('shop_order_detail')->where('o_id',$o_id)->get();
//        $g_name='';
//        foreach ($goods as $v){
//            $g_name .= $v->g_name.',';
//        }
//        $path = base_path();
//        include_once $path."/app/libs/alipay/pagepay/service/AlipayTradeService.php";
//        include_once $path."/app/libs/alipay/pagepay/buildermodel/AlipayTradePagePayContentBuilder.php";
//        //商户订单号，商户网站订单系统中唯一订单号，必填
//        $out_trade_no = $order->o_no;
//
//        //订单名称，必填
//        $subject = $g_name;
//
//        //付款金额，必填
//        $total_amount = $order->o_amount;
//
//        //商品描述，可空
//        $body = '速度发货';
//
//        //构造参数
//        $payRequestBuilder = new \AlipayTradePagePayContentBuilder();
//        // dump($payRequestBuilder);exit;
//        $payRequestBuilder->setBody($body);
//        $payRequestBuilder->setSubject($subject);
//        $payRequestBuilder->setTotalAmount($total_amount);
//        $payRequestBuilder->setOutTradeNo($out_trade_no);
//
//        $config = config('pay');
////        dd($config);
//        // dump($config);exit;
//        $aop = new \AlipayTradeService($config);
//
//        /**
//         * pagePay 电脑网站支付请求
//         * @param $builder 业务参数，使用buildmodel中的对象生成。
//         * @param $return_url 同步跳转地址，公网可以访问
//         * @param $notify_url 异步通知地址，公网可以访问
//         * @return $response 支付宝返回的信息
//         */
//        $response = $aop->pagePay($payRequestBuilder,$config['return_url'],$config['notify_url']);
//
//
//    }
    //同步跳转
    public function successPay(){
        require_once app_path('libs/alipay/pagepay/service/AlipayTradeService.php');
        $arr=$_GET;
        $order = htmlspecialchars($_GET['out_trade_no']);
        $config = config('pay');
        $alipaySevice = new \AlipayTradeService($config);
        $order = $arr['out_trade_no'];
        $where = [
            'o_no'=>$arr['out_trade_no'],
            'o_amount'=>$arr['total_amount']
        ];
        $count = DB::table('shop_order')->where($where)->count();
        if (!$count){
            Log::channel('alipay')->info('没有此订单号'.$order);
        }
        if ($config['app_id']!=$arr['app_id']||$config['seller_id']!=$arr['seller_id']){
            Log::channel('alipay')->info('商户不符合'.$order);
        }
        $result = $alipaySevice->check($arr);
        /* 实际验证过程建议商户添加以下校验。
        1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
        2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
        3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
        4、验证app_id是否为该商户本身。
        */
        if($result) {//验证成功
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //请在这里加上商户的业务逻辑程序代码

            //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
            //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表

            //支付宝交易号  htmlspecialchars 将特殊字符转换为 HTML 实体
            $trade_no = htmlspecialchars($_GET['trade_no']);
            Log::channel('alipay')->info("验证成功<br />支付宝交易号：".$trade_no);
            return redirect('/');

            //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——

            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        }
        else {
            //验证失败
            Log::channel('alipay')->info('验证失败'.$order);
        }
    }
    public function payment(){
        $o_id = request()->input('o_id');
        $order = DB::table('shop_order')->where('o_id',$o_id)->first();
        $goods = DB::table('shop_order_detail')->where('o_id',$o_id)->get();
        $g_name='';
        foreach ($goods as $v){
            $g_name .= $v->g_name.',';
        }
        $path = base_path();
        include_once $path."/app/libs/wapalipay/wappay/service/AlipayTradeService.php";
        include_once $path."/app/libs/wapalipay/wappay/buildermodel/AlipayTradeWapPayContentBuilder.php";
      //商户订单号，商户网站订单系统中唯一订单号，必填
        $out_trade_no = $order->o_no;

        //订单名称，必填
        $subject = $g_name;

        //付款金额，必填
        $total_amount = $order->o_amount;

        //商品描述，可空
        $body = '速度发货';

            //超时时间
            $timeout_express="1m";

            $payRequestBuilder = new \AlipayTradeWapPayContentBuilder();
            $payRequestBuilder->setBody($body);
            $payRequestBuilder->setSubject($subject);
            $payRequestBuilder->setOutTradeNo($out_trade_no);
            $payRequestBuilder->setTotalAmount($total_amount);
            $payRequestBuilder->setTimeExpress($timeout_express);
            $config = config('pay');
            $payResponse = new \AlipayTradeService($config);
            $result=$payResponse->wapPay($payRequestBuilder,$config['return_url'],$config['notify_url']);

            return ;
    }
}
