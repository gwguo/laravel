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
    <div class="dingdanlist"">
        <table>
            <tr><td colspan="3" style="height:10px; background:#efefef;padding:0;"></td></tr>
            <tr>
                <td class="dingimg" width="75%" colspan="2"><a  class="orange" href="/address/add">新增收货地址</a></td>
            </tr>
            <tr><td colspan="3" style="height:10px; background:#efefef;padding:0;"></td></tr>
            <tr>
                <td class="dingimg" width="75%" colspan="2">选择收货人</td>
                <td align="right">
                    @foreach($address as $v)
                        <input type="radio" name="add_exist" value="{{$v->add_id}}" @if($v->add_exist==1) checked @endif>
                        <option value="{{$v->add_id}}">{{$v->add_name}}</option>
                    @endforeach
                </td>
            </tr>
            <tr>
                <td colspan="3" style="height:10px; background:#efefef;padding:0;"></td>
            </tr>
            <tr>
                <td class="dingimg" width="75%" colspan="2">支付方式</td>
                <td align="right">
                    <select name="" id="pay_type">
                        <option value="1">网上支付</option>
                        <option value="2">货到付款</option>
                        <option value="3">分期付款</option>
                    </select>
                </td>
            </tr>
            @foreach($cartInfo as $v)
            <tr>
                <td class="dingimg" width="15%"><img src="/index/images/pro1.jpg" /></td>
                <td width="50%">
                    <h3>{{$v->g_name}}</h3>
                    <time>下单时间：{{date('Y-m-d h:i:s',$v->create_time)}}</time>
                </td>
                <td align="right"><span class="qingdan">X {{$v->car_num}}</span></td>
            </tr>
            <tr>
                <th colspan="3"><strong class="orange">¥{{$v->g_price*$v->car_num}}</strong></th>
            </tr>
            @endforeach
            <tr>
                <td class="dingimg" width="75%" colspan="2">商品金额</td>
                <td align="right"><strong class="orange">¥{{$moneyAll}}</strong></td>
            </tr>
        </table>
    </div><!--dingdanlist/-->
</div><!--content/-->
<input type="hidden" name="g_id" value="{{$g_id}}">
<div class="height1"></div>
<div class="gwcpiao">
    <table>
        <tr>
            <th width="10%"><a href="javascript:history.back(-1)"><span class="glyphicon glyphicon-menu-left"></span></a></th>
            <td width="50%">总计：<strong class="orange">¥{{$moneyAll}}</strong></td>
            <td width="40%"><a href="javascript:;" class="jiesuan" id="jiesuan">结算</a></td>
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
            $('#jiesuan').click(function(){
                var g_id = $('input[name=g_id]').val();
                var exist = $('input[name=add_exist]');
                var add_id='';
                var pay_type=$('#pay_type').val();
                exist.each(function(index){
                    // console.log(index);代表下标
                    if($(this).prop('checked')==true){
                        add_id =$(this).val();
                    }
                })
                if(add_id==''){
                    alert('请选择收货地址');
                    return false;
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.post(
                    "/cart/orderForm",
                    {g_id:g_id,add_id:add_id,pay_type:pay_type},
                    function(res){
                        layer.msg(res.font,{icon:res.code});
                        if(res.code==1){
                            location.href="/pay?o_id="+res.o_id;
                        }
                    },
                    'json'
                );
            })
        })
    })
</script>