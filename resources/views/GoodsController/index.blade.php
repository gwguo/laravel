<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Author" contect="http://www.webqin.net">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>三级分销</title>
    <link rel="shortcut icon" href="/index/images/favicon.ico" />

    <!-- Bootstrap -->
    <link href="/index/css/bootstrap.min.css" rel="stylesheet">
    <link href="/index/css/style.css" rel="stylesheet">
    <link href="/index/css/response.css" rel="stylesheet">
    <script src="/js/jquery-3.2.1.min.js"></script>
    <script src="/layui/layui.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="maincont">
    <header>
        <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
        <div class="head-mid">
            <h1>产品详情</h1>
        </div>
    </header>
    <div>
        <img src="/index/images/image1.jpg" />
    </div><!--sliderA/-->
    <table class="jia-len">
        <input type="hidden" name="g_id" value="{{$goods->g_id}}">
        <input type="hidden" name="g_num" value="{{$goods->g_num}}">
        <tr>
            <th class="orange"><strong id="price">{{$goods->g_price}}</strong>￥</th>
            <td>
                <input type="button" value="-"  class="n_btn_1" />
                <input type="text" value="1" class="spinner" />
                <input type="button" value="+"  class="n_btn_2" />
            </td>
        </tr>
        <tr>
            <td>
                <strong class="orange">{{$goods->g_name}}</strong>
            </td>
            <td align="right">
                <a href="javascript:;" class="shoucang">
                    <span class="glyphicon glyphicon-star-empty"></span>
                </a>
            </td>
        </tr>
    </table>
    <div class="height2"></div>
    <div class="height2"></div>
    <table class="jrgwc">
        <tr>
            <th>
                <a href="index.html"><span class="glyphicon glyphicon-home"></span></a>
            </th>
            <td><a href="javascript:;" class="orange" id="img">加入购物车</a></td>
        </tr>
    </table>
</div><!--maincont-->
<script src="/index/js/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/index/js/bootstrap.min.js"></script>
<script src="/index/js/style.js"></script>
@include('public/footNav')
</body>
</html>
<script>
    $(function(){
        layui.use(['layer'],function(){
            var price = $('#price');
            var price1 = parseInt($('#price').text());
            var layer = layui.layer;
            var num = $('input[name=g_num]').val();
            $('.n_btn_2').click(function(){
                var g_num = parseInt($('.spinner').val());
                if (g_num>=num) {
                    $('.spinner').val(num);
                }else{
                    g_num = g_num+1;
                    $('.spinner').val(g_num);
                    price.text(price1*g_num);
                }
            })
            $('.n_btn_1').click(function(){
                var g_num = parseInt($('.spinner').val());
                if (g_num<=1) {
                    $('.spinner').val(1);
                }else{
                    g_num = g_num-1;
                    $('.spinner').val(g_num);
                    price.text(price1*g_num);
                }
            })
            $('.spinner').blur(function(){
                var g_num = $('.spinner').val();
                var reg = /\d{1,}/;
                if (g_num=='') {
                    $('.spinner').val(1);
                }else if(!reg.test(g_num)||parseInt(g_num)<=1){
                    $('.spinner').val(1);
                }else if(parseInt(g_num)>=num){
                    $('.spinner').val(num);
                }else{
                    g_num = parseInt(g_num);
                    $('.spinner').val(g_num);
                }
            });
            $('#img').click(function(){
                var g_num = $('.spinner').val();
                var g_id = $('input[name=g_id]').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.post(
                    "/cart",
                    {g_id:g_id,g_num:g_num},
                    function(res){
                        layer.msg(res.font,{icon:res.code,time:2000},function(){
                            if(res.code==1) {
                                layer.confirm('是否进入购物车', function () {
                                    location.href = "/cart/index";
                                });
                            }
                        });
                    },
                    'json'
                )
            })
        });
    });
</script>