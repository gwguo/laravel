<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="/js/jquery-3.1.1.min.js"></script>
<script src="/layui/layui.js"></script>
<form action="" onsubmit="return false">
    用户名：<input type="text" name="u_email"><br>
    密码：<input type="password" name="u_pwd"><br>
    <input type="submit" value="登录" id="dl"><br>
</form>
<script>
    $(function(){
        layui.use(['layer'],function(){
            $('#dl').click(function(){
                var u_email = $('input[name=u_email]').val();
                if(u_email==''){
                    layer.msg('邮箱不能为空',{icon:2});
                    return false;
                }
                var u_pwd = $('input[name=u_pwd]').val();
                if(u_pwd==''){
                    layer.msg('密码不能为空',{icon:2});
                    return false;
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.post(
                    '/Klondo',
                    {u_email:u_email,u_pwd:u_pwd},
                    function(res){
                        layer.msg(res.font,{icon:res.code,time:1500},function(){
                            if(res.code==1){
                                location.href="/Kuser";
                            }
                        });
                    },
                    'json'
                )
            })
        })
    })
</script>