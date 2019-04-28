<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Author" contect="http://www.webqin.net">
    <title>三级分销</title>
    <link rel="shortcut icon" href="/index/images/favicon.ico" />
    <script src="/js/jquery-3.2.1.min.js"></script>
    <script src="/layui/layui.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap -->
    <link href="/index/css/bootstrap.min.css" rel="stylesheet">
    <link href="/index/css/style.css" rel="stylesheet">
    <link href="/index/css/response.css" rel="stylesheet">
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
            <h1>购物车</h1>
        </div>
    </header>
    <div class="head-top">
        <img src="/index/images/head.jpg" />
    </div><!--head-top/-->
    <table class="shoucangtab">
        <tr>
            <td width="75%"><span class="hui">购物车共有：
                    <strong class="orange">{{$count}}</strong>件商品</span>
            </td>
        </tr>
    </table>
    <table>
    <tr>
        <td width="100%"><input type="checkbox" id="box"/> 全选</td>
    </tr>
    </table>
    @foreach($cartInfo as $v)
    <div class="dingdanlist">
        <table num="{{$v->g_num}}">
            <tr g_id="{{$v->g_id}}">
                <td width="4%"><input type="checkbox" class="smallBox" /></td>
                <td class="dingimg" width="15%"><img src="/index/images/pro1.jpg" /></td>
                <td width="50%">
                    <h3>{{$v->g_name}}</h3>
                    <time>{{date('Y-m-d h:i:s',$v->create_time)}}</time>
                </td>
                <td align="right">
                    <input type="button" value="-"  class="n_btn_1" />
                    <input type="text" value="{{$v->car_num}}"  class="spinner" />
                    <input type="button" value="+"  class="n_btn_2" />
                </td>
            </tr>
            <tr>
                <th colspan="4" class="orange">¥<strong class="price">{{$v->g_price}}</strong></th>
            </tr>
        </table>
    </div>
    @endforeach
    <div class="height1"></div>
    <div class="gwcpiao">
        <table>
            <tr>
                <th width="10%"><a href="javascript:history.back(-1)"><span class="glyphicon glyphicon-menu-left"></span></a></th>
                <td width="50%" class="orange">总计：¥<strong id="b">0</strong></td>
                <td width="40%"><a href="javascript:;" id="jiesuan" class="jiesuan">提交订单</a></td>
            </tr>
        </table>
    </div><!--gwcpiao/-->
</div><!--maincont-->
</body>
</html>
<script>
    $(function(){
        layui.use(['layer'],function(){
            var layer = layui.layer;
            //点击加号
            $('.n_btn_2').click(function(){
                var num = $(this).parents('table').attr('num');
                var g_num = parseInt($(this).prev('.spinner').val());
                if (g_num>=num) {
                    $(this).prev('.spinner').val(num);
                }else{
                    g_num = g_num+1;
                    $(this).prev('.spinner').val(g_num);
                }
                //调用方法使数据库中更改数量
                var g_num = parseInt($(this).prev('.spinner').val());
                var g_id = $(this).parents('tr').attr('g_id');
                changeCartNum(g_id,g_num);
            })
            //点击减号
            $('.n_btn_1').click(function(){
                var num = $(this).parents('table').attr('num');
                var g_num = parseInt($(this).next('.spinner').val());
                if (g_num<=1) {
                    $(this).next('.spinner').val(1);
                }else{
                    g_num = g_num-1;
                    $(this).next('.spinner').val(g_num);
                }
                //调用方法使数据库中更改数量
                var g_num = parseInt($(this).next('.spinner').val());
                var g_id = $(this).parents('tr').attr('g_id');
                changeCartNum(g_id,g_num);
            })
            //失去焦点
            $('.spinner').blur(function(){
                var num = parseInt($(this).parents('table').attr('num'));
                var g_num = $(this).val();
                var reg = /\d{1,}/;
                if (g_num=='') {
                    $(this).val(1);
                }else if(!reg.test(g_num)||parseInt(g_num)<=1){
                    $(this).val(1);
                }else if(parseInt(g_num)>=num){
                    $(this).val(num);
                }else{
                    g_num = parseInt(g_num);
                    $(this).val(g_num);
                }
            });
            //点击复选框
            $('.smallBox').click(function(){
                var box = $('.smallBox');
                var g_id = '';
                box.each(function(index){
                    // console.log(index);代表下标
                    if ($(this).prop('checked')) {
                        g_id += $(this).parents('tr').attr('g_id')+',';
                    }
                });
                g_id = g_id.substr(0,g_id.length-1);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.post(
                    "/cart/countTotal",
                    {g_id:g_id},
                    function(res){
                        $('#b').text(res);
                    }
                );
            });
            //全选
            $('#box').click(function(){
                var _this = $(this);
                var box = $('#box').prop('checked');
                var smallBox = $('.smallBox');
                if (box) {
                    smallBox.prop('checked',true);
                }else{
                    smallBox.prop('checked',false);
                }
                moneyAll();
            });
            //获取商品总价格
            function moneyAll(){
                var box = $('.smallBox');
                var g_id = '';
                box.each(function(index){
                    // console.log(index);代表下标
                    if ($(this).prop('checked')) {
                        g_id += $(this).parents('tr').attr('g_id')+',';
                    }
                });
                g_id = g_id.substr(0,g_id.length-1);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.post(
                    "/cart/money",
                    {g_id:g_id},
                    function(res){
                        $('#b').text(res);
                    }
                );
            }
            //修改购买数量
            function changeCartNum(g_id,car_num){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                //更改购买数量  超出数量给出提示
                $.ajax({
                    url:"/cart/changeCartNum",
                    method:'post',
                    data:{g_id:g_id,car_num:car_num},
                    async:false,
                    success:function(res){
                        if (res.code == 2) {
                            layer.msg(res.font,{icon:res.code});
                        }
                    }
                });
            }
            //获取城市信息
            $(document).on('change','.area',function(){
                var _this = $(this);
                var id = _this.val();
                var _option = "<option value='0' selected='selected'>--请选择--</option>";
                _this.nextAll().html(_option);
                // console.log(_option);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.post(
                    "/address/city",
                    {id:id},
                    function(res){
                        for (var i in res) {
                            _option +="<option value='"+res[i]['id']+"' >"+res[i]['name']+"</option>";
                        };
                        _this.parent('div').next('div').children('select').html(_option);
                    },
                    'json'
                );
            })
            //结算
            $('#jiesuan').click(function(){
                var box = $('.smallBox');
                var g_id = '';
                box.each(function(index){
                    // console.log(index);代表下标
                    if ($(this).prop('checked')) {
                        g_id += $(this).parents('tr').attr('g_id')+',';
                    }
                });
                if(g_id==''){
                    alert('请选择商品');
                    return false;
                }
                g_id = g_id.substr(0,g_id.length-1);
                location.href = "/cart/order?g_id="+g_id;
            })
        });
    });
</script>