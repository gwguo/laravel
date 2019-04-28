<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="{{asset('js/jquery-3.1.1.min.js')}}"></script>
{{--输出错误信息--}}
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <p style="color:red">{{ $error }}</p>
            @endforeach
        </ul>
    </div>
@endif
<form action="adddo" method="post" enctype="multipart/form-data">
    {{--post表单提交保护--}}
    {{csrf_field()}}
    姓名：<input type="text" name="name"><br>
    年龄：<input type="text" name="sex"><br>
    密码：<input type="password" name="pwd"><br>
    头像：<input type="file" name="file"><br>
    <input type="submit" value="提交">
</form>
<script>
    $(function(){
        var flag = false;
        var flag1 = false;
        $('input[name=name]').blur(function(){
            var name = $(this).val();
            var reg = /^\w{2,10}$/;
            if(name==''){
                alert('用户名不能为空');
                flag1 = false;
            }else if(!reg.test(name)){
                alert('用户名为2-10位数字，字母，下划线，组成');
                flag1 = false;
            }else{
                //ajax提交保护
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.post(
                    "checkName",
                    {name:name},
                    function(msg){
                        if(msg.code==1){
                            flag1 = true;
                        }else{
                            alert(msg.font);
                            flag1 = false;
                        }
                    },
                    'json'
                )
            }
        })
        $('input[name=sex]').blur(function() {
            var sex = $(this).val();
            var reg = /^[0-9]+$/;
            if (sex == '') {
                alert('年龄不能为空');
                flag = false;
            } else if (!reg.test(sex)) {
                alert('年龄为数字');
                flag = false;
            }else{
                flag=true;
            }
        })
        $('form').submit(function(){
            if(flag1&&flag){
                return true;
            }else{
                return false;
            }
        })
    })
</script>