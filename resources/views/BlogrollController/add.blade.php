<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="{{asset('js/jquery-3.1.1.min.js')}}"></script>
{{--输出添加是否成功--}}
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
<form action="adddo" method="post" enctype="multipart/form-data">
    {{csrf_field()}}
    网站名称：<input type="text" name="name"><br>
    网站网址：<input type="text" name="sites"><br>
    网站类型：<input type="radio" name="type" value="LOGO链接">LOGO链接
              <input type="radio" name="type" value="文字连接">文字连接<br>
    图片LOGO：<input type="file" name="logo"><br>
    网站联系人：<input type="text" name="linkname"><br>
    网站介绍：<input type="text" name="desc"><br>
    是否显示：<input type="radio" name="show" value="是">是
              <input type="radio" name="show" value="否">否<br>
    提交：<input type="submit" value="提交"><br>
</form>
<script>
    $(function(){
        var falg = false;
        $('input[name=name]').blur(function(){
            checkName();
        })
        function checkName(){
                var name = $('input[name=name]').val();
                var reg = /^[a-zA-Z0-9 \u4e00-\u9fa5]{2,10}$/;
                if(name==''){
                    alert('网站名称不能为空');
                    falg = false;
                }else if(!reg.test(name)){
                    alert('网站名称为2-10位中文，数字，字母，下划线，组成');
                    falg = false;
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
                                falg = true;
                            }else{
                                alert(msg.font);
                                falg = false;
                            }
                        },
                        'json'
                    )
                }
        }
        $('input[name=sites]').blur(function(){
            checkSites();
        })
        function checkSites(){
            var sites = $('input[name=sites]').val();
            var reg = /^(http:\/\/)/;
            if(sites==''){
                alert('网址不能为空');
                return false;
            }else if(!reg.test(sites)){
                alert('网址必须http://开头，中文数字字母下划线10-30位组成');
                return false;
            }else{
                return true;
            }
        }
        $('form').submit(function(){
            checkSites();
            checkName()
            if(falg&&checkSites()){
                return true;
            }else{
                return false;
            }
        })
    })
</script>