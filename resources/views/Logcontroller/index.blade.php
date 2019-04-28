<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="/js/jquery-3.1.1.min.js"></script>
@extends('layouts.layout')
@section('content')
<form action="" onsubmit="return false" method="get" class="reg-login layui-form">
        <h3>还没有三级分销账号？点此<a class="orange" href="/register">注册</a></h3>
        <div class="lrBox">
            <div class="lrList"><input type="text" id="name" name="name" placeholder="输入手机号码或者邮箱号" /></div>
            <div class="lrList"><input type="password" id="u_pwd" name="u_pwd" placeholder="输入证码" /></div>
        </div><!--lrBox/-->
        <div class="lrSub">
            <input type="submit" id="btn" value="立即登录" />
        </div>
</form>
@endsection
<script>
    $(function(){
        layui.use(['layer'],function(){
            var layer=layui.layer;
            $('#btn').click(function(){
                //获取账号 密码
                //账号
                var name=$('#name').val();
                //密码
                var u_pwd=$('#u_pwd').val();
                if(name==''){
                    layer.msg('手机号或邮箱必填',{icon:2});
                    return false;
                }
                if(u_pwd==''){
                    layer.msg('密码必填',{icon:2});
                    return false;
                }
                //把账号 密码通过ajax传给控制器
                // console.log(account,user_pwd,remember_me);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.post(
                    "/log/login",
                    {name:name,u_pwd:u_pwd},
                    function(msg){
                        layer.msg(msg.font,{icon:msg.code});
                        if(msg.code==1){
                            location.href="/";
                        }
                    },
                    'json'
                );
            });
        })
    })
</script>
