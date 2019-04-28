<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
class KloginController extends Controller
{
    public function reg(){
        return view('KloginController.reg');
    }
    public function sendEmail(){
        $u_email = request()->input('u_email');
        //随机数
        $send = rand(100000,999999);
        Mail::send(
        //必须用一视图   作为发送内容
            'email.emailBoby',
            //发送的随机数
            ['content'=>$send],
            function ($message)use($u_email,$send){
                //发送邮件和标题
                $res = $message->to($u_email)->subject('欢迎注册');
                if ($res){
                    $user = [
                        'time'=>time(),
                        'u_email'=>$u_email,
                        'send'=>$send
                    ];
                    request()->session()->put('user',$user);
                    echo json_encode(['font'=>'发送成功','code'=>1]);
                }else{
                    echo json_encode(['font'=>'发送失败','code'=>2]);
                }
            }
        );
    }
    public function zc(){
        $data = request()->all();
        $sess = request()->session()->get('user');
        if ($data['u_email']!=$sess['u_email']){
            echo json_encode(['font'=>'邮箱不一致','code'=>2]);die;
        }
        $time = $sess['time']-time();
        if ($time>1200000){
            echo json_encode(['font'=>'验证码已过期','code'=>2]);die;
        }
        if ($data['u_code']!=$sess['send']){
            echo json_encode(['font'=>'验证码不一致','code'=>2]);die;
        }
        if ($data['u_pwd']!=$data['new_pwd']){
            echo json_encode(['font'=>'密码不一致','code'=>2]);die;
        }
        unset($data['new_pwd']);
        $data['u_time'] = time();
        $res = DB::table('shop_user')->insert($data);
        if ($res){
            echo json_encode(['font'=>'注册成功','code'=>1]);
        }else{
            echo json_encode(['font'=>'注册失败','code'=>2]);die;
        }
    }
    public function Klog(){
        return view('KloginController.Klog');
    }
    public function Klondo(){
        $u_email = request()->input('u_email');
        $u_pwd = request()->input('u_pwd');
        $user = DB::table('shop_user')->where('u_email',$u_email)->first();
        if (!$user){
            echo json_encode(['font'=>'邮箱不一致','code'=>2]);die;
        }
        if($user->u_pwd!=$u_pwd){
            $time = time()-$user->last_error_time;
            if($time>60*60){
                $update = [
                  'error_num'=>$user->error_num+1,
                  'last_error_time'=>time()
                ];
                DB::table('shop_user')->where('u_id',$user->u_id)->update($update);
                echo json_encode(['font'=>'密码错误','code'=>2]);die;
            }else{
                if ($user->error_num<5){
                    $update = [
                        'error_num'=>$user->error_num+1,
                        'last_error_time'=>time()
                    ];
                    DB::table('shop_user')->where('u_id',$user->u_id)->update($update);
                    echo json_encode(['font'=>'密码错误','code'=>2]);die;
                }else{
                    echo json_encode(['font'=>'账号已锁定请一小时后登陆','code'=>2]);die;
                }
            }
        }else{
            $time = time()-$user->last_error_time;
            if ($user->error_num>=5&&$time<3600){
                $t = 60-ceil($time/60);
                echo json_encode(['font'=>'账号已锁定请'.$t.'分钟后登陆','code'=>2]);die;
            }else{
                $update = [
                    'error_num'=>0,
                    'last_error_time'=>null
                ];
                DB::table('shop_user')->where('u_id',$user->u_id)->update($update);
                Cache::put('user', $user);
                echo json_encode(['font'=>'登录成功','code'=>1]);
            }
        }
    }
    public function Kuser(){
        $user = Cache::get('user');
        return view('KloginController.Kuser',compact('user'));
    }
}
