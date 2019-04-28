<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="/js/jquery-3.1.1.min.js"></script>
@extends('layouts.layout')
@section('content')
    <form action="login.html" method="get" onsubmit="return false" class="reg-login layui-form">
        <h3>已经有账号了？点此<a class="orange" href="/log">登陆</a></h3>
        <div class="lrBox">
            <div class="lrList"><input type="text"value="" name="u_email" id="email" placeholder="输入手机号码或者邮箱号" /></div>
            <div class="lrList2"><input type="text" name="u_code" placeholder="输入短信验证码" /> <button id="span_email">获取验证码</button></div>
            <div class="lrList"><input type="password" name="u_pwd" placeholder="设置新密码（6-18位数字或字母）" /></div>
            <div class="lrList"><input type="password" name="u_pwd1" placeholder="再次输入密码" /></div>
        </div><!--lrBox/-->
        <div class="lrSub">
            <input type="submit" lay-submit lay-filter="*" value="立即注册" />
        </div>
    </form><!--reg-login/-->
@endsection
<script>
    $(function(){
        layui.use(['form','layer'],function(){
            var form = layui.form;
            var layer = layui.layer;
            var flag = false;
            //单击获取判断邮箱
            $('#span_email').click(function(){
                var _this = $(this);
//                alert(1);
                //获取邮箱值
                var email = $('#email').val();
                //自定义验证规则
                var reg = /^\w+@\w+\.com$/;
                var reg1 = /^[1][0-9]{10}$/;
                if (email=='') {
                    layer.msg('邮箱或手机号不能为空',{icon:2});
                    return false;
                }else if(!reg.test(email)&&!reg1.test(email)){
                    layer.msg('请输入正确邮箱或手机号',{icon:2,time:2000});
                    return false;
                }else{
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    //通过ajax将邮箱传到后台
                    $.ajax({
                        type:'post',
                        url:"/log/checkEmail",
                        data:{email:email},
                        dataType:'json',
                        async:false
                    }).done(function(msg){
                        if(msg.code==1){
                            flag = true;
                        }else{
                            layer.msg(msg.font,{icon:msg.code});
                            flag = false;
                        }
                    });
                    if (flag==false) {
                        return flag;
                    }
                }

                //设置秒数倒计时
                _this.text(60+'s');
                _this.css('pointer-events','none');
                //1000是毫秒  timeless是方法
                set1 = setInterval(timeless,1000);
                //秒数倒计时
                function timeless(){
                    //获取值  将字符串转化为整型
                    var _time =parseInt($('#span_email').text());
                    if (_time == 0) {
                        $('#span_email').text('获取验证码');
                        clearInterval(set1);
                        //允许点击
                        $('#span_email').css('pointer-events','auto');
                    }else{
                        _time = _time-1;//秒数减一
                        $('#span_email').text(_time+'s');
                        $('#span_email').css('pointer-events','none');
                    }
                }
                // 将邮箱发送给控制器	发送邮件
                if(reg.test(email)){
                    $.post(
                        "/log/sendEmail",
                        {email:email},
                        function(msg){
                            if (msg.code==1) {
                                layer.msg(msg.font,{icon:msg.code});
                            }else{
                                layer.msg(msg.font,{icon:msg.code});
                            }
                        },
                        'json'
                    );
                }else if(reg1.test(email)){
                    $.post(
                        "/log/sendPhone",
                        {email:email},
                        function(msg){
                            if (msg.code==1) {
                                layer.msg(msg.font,{icon:msg.code});
                                location.href="/log";
                            }else{
                                layer.msg(msg.font,{icon:msg.code});
                            }
                        },
                        'json'
                    );
                }
            });
            form.on('submit(*)',function(data){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.post(
                    "/log/registerDo",
                    data.field,
                    function(msg){
                        layer.msg(msg.font,{icon:msg.code,time:1500},function(){
                            if (msg.code==1) {
                                location.href = "/log";
                            }
                        });
                    },
                    'json'
                );
                return false;
            });
        });
    })
</script>