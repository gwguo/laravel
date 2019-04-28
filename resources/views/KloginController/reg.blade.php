<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="/js/jquery-3.1.1.min.js"></script>
<script src="/layui/layui.js"></script>
<form action="" onsubmit="return false">
    QQ邮箱<input type="text" name="u_email"><br>
    验证码<input type="text" name="u_code"><button id="email">验证码</button><br>
    密码<input type="password" name="u_pwd"><br>
    确认密码<input type="password" name="new_pwd"><br>
    <input type="submit" value="注册" id="zc"><br>
</form>
<script>
    $(function(){
        layui.use(['form','layer'],function(){
            var layer = layui.layer;
            var form = layui.form;
            $('#email').click(function(){
                var u_email = $('input[name=u_email]').val();
                var reg = /^\w+@\w+\.com$/;
                if(u_email==''){
                    layer.msg('邮箱不能为空',{icon:2});
                    return false;
                }else if(!reg.test(u_email)){
                    layer.msg('邮箱不正确',{icon:2});
                    return false;
                }else{
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.post(
                        '/sendEmail',
                        {u_email:u_email},
                        function(res){
                            layer.msg(res.font,{icon:res.code});
                        },
                        'json'
                    )
                }
            })
            $('#zc').click(function(){
                var u_email = $('input[name=u_email]').val();
                if(u_email==''){
                    layer.msg('邮箱不能为空',{icon:2});
                    return false;
                }
                var u_code = $('input[name=u_code]').val();
                if(u_code==''){
                    layer.msg('验证码不能为空',{icon:2});
                    return false;
                }
                var u_pwd = $('input[name=u_pwd]').val();
                if(u_pwd==''){
                    layer.msg('密码不能为空',{icon:2});
                    return false;
                }
                var new_pwd = $('input[name=new_pwd]').val();
                if(new_pwd==''){
                    layer.msg('确认密码不能为空',{icon:2});
                    return false;
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.post(
                    '/zc',
                    {u_email:u_email,u_code:u_code,u_pwd:u_pwd,new_pwd:new_pwd},
                    function(res){
                        layer.msg(res.font,{icon:res.code,time:1500},function(){
                            if(res.code==1){
                                location.href="/Klog";
                            }
                        });
                    },
                    'json'
                )
            })
        })
    })
</script>