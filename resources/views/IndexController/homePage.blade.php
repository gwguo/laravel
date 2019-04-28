<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="Author" contect="http://www.webqin.net">
    <title>三级分销</title>
    <link rel="shortcut icon" href="/index/images/favicon.ico" />

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
    <div class="head-top">
        <img src="/index/images/head.jpg" />
        <dl>
            <dt><a href="/user"><img src="/index/images/touxiang.jpg" /></a></dt>
            <dd>
                <h1 class="username">三级分销终身荣誉会员</h1>
                <ul>
                    <li><a href="/list"><strong>{{$count}}</strong><p>全部商品</p></a></li>
                    <li><a href="javascript:;"><span class="glyphicon glyphicon-star-empty"></span><p>收藏本店</p></a></li>
                    <li style="background:none;"><a href="javascript:;"><span class="glyphicon glyphicon-picture"></span><p>二维码</p></a></li>
                    <div class="clearfix"></div>
                </ul>
            </dd>
            <div class="clearfix"></div>
        </dl>
    </div><!--head-top/-->
    <form action="/list" method="get" class="search">
        <input type="text" name="g_name" class="seaText fl" />
        <input type="submit" value="搜索" class="seaSub fr" />
    </form><!--search/-->
    <ul class="reg-login-click">
        <li><a href="/log">登录</a></li>
        <li><a href="/register" class="rlbg">注册</a></li>
        <div class="clearfix"></div>
    </ul><!--reg-login-click/-->
    <div id="sliderA" class="slider">
        <img src="/index/images/image1.jpg" />
    </div><!--sliderA/-->
    <ul class="pronav">
        @foreach($cate as $v)
        <li><a href="/list?c_id={{$v->c_id}}">{{$v->c_name}}</a></li>
        @endforeach
        <div class="clearfix"></div>
    </ul><!--pronav/-->
    <div class="index-pro1">
        @foreach($goods as $v)
        <div class="index-pro1-list">
            <dl>
                <dt><a href="/goods?g_id={{$v->g_id}}"><img src="/index/images/pro1.jpg" /></a></dt>
                <dd class="ip-text"><a href="/goods?g_id={{$v->g_id}}">{{$v->g_name}}</a><span>库存：{{$v->g_num}}</span></dd>
                <dd class="ip-price"><strong>¥{{$v->g_price}}</strong> <span>¥{{$v->g_mprice}}</span></dd>
            </dl>
        </div>
        @endforeach
        <div class="clearfix"></div>
    </div><!--index-pro1/-->
    <div class="joins"><a href="javascript:;"><img src="/index/images/jrwm.jpg" /></a></div>
    <div class="copyright">Copyright &copy; <span class="blue">这是就是三级分销底部信息</span></div>

    <div class="height1"></div>
    <div class="footNav">
        <dl>
            <a href="index.html">
                <dt><span class="glyphicon glyphicon-home"></span></dt>
                <dd>微店</dd>
            </a>
        </dl>
        <dl>
            <a href="/list">
                <dt><span class="glyphicon glyphicon-th"></span></dt>
                <dd>所有商品</dd>
            </a>
        </dl>
        <dl>
            <a href="/cart">
                <dt><span class="glyphicon glyphicon-shopping-cart"></span></dt>
                <dd>购物车 </dd>
            </a>
        </dl>
        <dl>
            <a href="/user">
                <dt><span class="glyphicon glyphicon-user"></span></dt>
                <dd>我的</dd>
            </a>
        </dl>
        <div class="clearfix"></div>
    </div><!--footNav/-->
</div><!--maincont-->
</body>
</html>