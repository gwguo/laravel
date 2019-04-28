<link href="/index/css/bootstrap.min.css" rel="stylesheet">
<link href="/index/css/style.css" rel="stylesheet">
<link href="/index/css/response.css" rel="stylesheet">
<script src="/js/jquery-3.2.1.min.js"></script>
<script src="/layui/layui.js"></script>
<script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="maincont">
        <form action="/list" method="get" class="search">
            <input type="text" name="g_name" value="{{$g_name}}" class="seaText fl" />
            <input type="submit" value="搜索" class="seaSub fr" />
        </form>
<ul class="pro-select">
    <li class="pro-selCur tiao" is_type="1" field="create_time"><a href="javascript:;">新品</a></li>
    <li class="tiao" is_type="2" field="g_num"><a href="javascript:;">销量</a></li>
    <li class="tiao" class="default" field="g_price" is_type="3"><a href="javascript:;">价格</a></li>
</ul><!--pro-select/-->
    <script>
        $('.tiao').click(function(){
            var _this = $(this);
            var is_type = _this.attr('is_type');
            var field = _this.attr('field');
            _this.addClass('pro-selCur');
            _this.siblings('li').removeClass('pro-selCur');
            var type='';
            if(is_type==1){
                type='desc';
                _this.attr('is_type',4);
            }else if(is_type==2){
                type='asc';
                _this.attr('is_type',5);
            }else if(is_type==3){
                type='asc';
                _this.attr('is_type',6);
            }else if(is_type==4){
                type='asc';
                _this.attr('is_type',1);
            }else if(is_type==5){
                type='desc';
                _this.attr('is_type',2);
            }else if(is_type==6){
                type='desc';
                _this.attr('is_type',3);
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post(
                '/lists',
                {field:field,type:type},
                function(res){
                    $('#div').html(res);
                }
            )
        })
    </script>
    <div class="prolist" id="div">
        @foreach($goods as $v)
        <dl>
            <dt><a href="/goods?g_id={{$v->g_id}}"><img src="/index/images/prolist1.jpg" width="100" height="100" /></a></dt>
            <dd>
                <h3><a href="/goods?g_id={{$v->g_id}}">{{$v->g_name}}</a></h3>
                <div class="prolist-price"><strong>¥{{$v->g_price}}</strong> <span>¥{{$v->g_mprice}}</span></div>
                <div class="prolist-yishou"><span>5.0折</span> <em>库存：{{$v->g_num}}</em></div>
            </dd>
            <div class="clearfix"></div>
        </dl>
            @endforeach
    </div>
</div>
@include('public.footNav')

