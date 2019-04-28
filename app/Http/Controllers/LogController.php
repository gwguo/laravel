<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class LogController extends Controller
{
    public function out(){
        $data = request()->session()->forget('userInfo');
//         request()->session()->put('userInfo',['a'=>'a']);
//         $data = request()->session()->get('userInfo');
        if (!$data){
            return redirect('/log');
        }
    }
    public function register(){
        return view('LogController/register');
    }
    public function registerDo(Request $request){
        $data = request()->all();
        $userInfo = session('userInfo');
        $email=$userInfo['u_email']??'';
        if ($email==''){
            $data['u_tel'] = $userInfo['u_tel'];
            unset($data['u_email']);
        }
        if (time()-$userInfo['time']>300000){
            echo json_encode(['font'=>'验证码已过期','code'=>2]);
        }
        if($data['u_pwd']!=$data['u_pwd1']){
            echo json_encode(['font'=>'两次密码不一致','code'=>2]);
        }else{
            unset($data['u_pwd1']);
        }
        if ($data['u_code']!=$userInfo['send']){
            echo json_encode(['font'=>'验证码不一致','code'=>2]);
        }
        $data['u_time'] = time();
        //加密
        $data['u_pwd'] = encrypt($data['u_pwd']);
        //解密
//        $data['u_pwd'] = decrypt($data['u_pwd']);
//        dd($data);
        $res = DB::table('shop_user')->insert($data);
        if ($res){
            echo json_encode(['font'=>'注册成功','code'=>1]);
        }else{
            echo json_encode(['font'=>'注册失败','code'=>2]);
        }
    }
    public function log(){
        return view('LogController/index');
    }
    public function checkEmail(){
        $email = request()->input('email');
        $count = DB::table('shop_user')->where('u_email',$email)->count();
        if ($count>0){
            echo json_encode(['font'=>'邮箱或手机号已被注册','code'=>2]);
        }else{
            echo json_encode(['font'=>'邮箱或手机号可以用','code'=>1]);
        }
    }
    public function sendEmail(){
        //接收邮箱
        $email = request()->input('email');
        //随机数
        $send = rand(100000,999999);
        Mail::send(
//必须用一视图   作为发送内容
            'email.emailBoby',
            //发送的随机数
            ['content'=>$send],
            function ($message)use($email,$send){
                //发送邮件和标题
                $res = $message->to($email)->subject('欢迎注册尤洪商城');

                if ($res){
                    $user = [
                        'time'=>time(),
                        'u_email'=>$email,
                        'send'=>$send
                    ];
                    request()->session()->put('userInfo',$user);
                    echo json_encode(['font'=>'发送成功','code'=>1]);
                }else{
                    echo json_encode(['font'=>'发送失败','code'=>2]);
                }
            }
        );
    }
    public function sendPhone(){
        $phone = request()->input('email');
        $rand = rand(100000,999999);
        $res = $this->phone($phone,$rand);
        $res = json_decode($res);
        if ($res['return_code']==00000){
            $user = [
                'time'=>time(),
                'u_tel'=>$phone,
                'send'=>$rand
            ];
            request()->session()->put('userInfo',$user);
            echo json_encode(['font'=>'发送成功','code'=>1]);
        }else{
            echo json_encode(['font'=>'发送失败','code'=>2]);
        }
    }
    public function phone($phone,$rand){
        $host = "http://dingxin.market.alicloudapi.com";
        $path = "/dx/sendSms";
        $method = "POST";
        $appcode = "617c2a0a782f4166b8788aacef14e337";
        $headers = array();
        array_push($headers, "Authorization:APPCODE " . $appcode);
        $querys = "mobile=".$phone."&param=code%3A".$rand."&tpl_id=TP1711063";
        $bodys = "";
        $url = $host . $path . "?" . $querys;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        if (1 == strpos("$".$host, "https://"))
        {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        var_dump(curl_exec($curl));
    }
    public function login(){
        $name = request()->input('name');
        $u_pwd = request()->input('u_pwd');
        $user = DB::table('shop_user')->where('u_email',$name)->
            orWhere('u_tel',$name)->get()->first();
        if ($user){
            $u_pwd1 = decrypt($user->u_pwd);
            if ($u_pwd1==$u_pwd){
                $user = [
                    'u_id'=>$user->u_id,
                    'name'=>$name
                ];
                request()->session()->put('userInfo',$user);
                echo json_encode(['font'=>'登录成功','code'=>1]);
            }else{
                echo json_encode(['font'=>'登录失败','code'=>2]);
            }
        }else{
            echo json_encode(['font'=>'登录失败','code'=>2]);
        }
    }
}
