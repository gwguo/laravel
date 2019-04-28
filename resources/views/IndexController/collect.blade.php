<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="/js/jquery-3.1.1.min.js"></script>
@extends('layouts.layout')
@section('content')
    <table class="shoucangtab">
        <tr>
            <td width="75%"><span class="hui">收藏栏共有：<strong class="orange">{{$count}}</strong>件商品</span></td>
            <td width="25%" align="center" style="background:#fff  left center no-repeat;">
                <a href="javascript:;" class="orange">全部删除</a>
            </td>
        </tr>
    </table>
    @foreach($goods as $v)
    <div class="dingdanlist">
        <table g_id="{{$v->g_id}}">
            <tr>
                <td colspan="2" width="65%"></td>
                <td width="35%" align="right">
                    <div class="quxiao"><a href="javascript:;" class="orange">取消收藏</a></div>
                </td>
            </tr>
            <tr>
                <td class="dingimg" width="15%"><img src="/index/images/pro1.jpg" /></td>
                <td width="50%">
                    <h3>{{$v->g_name}}</h3>
                </td>
                <td align="right"><img src="/index/images/jian-new.png" /></td>
            </tr>
            <tr>
                <th colspan="3"><strong class="orange">¥{{$v->g_price}}</strong></th>
            </tr>
        </table>
    </div><!--dingdanlist/-->
    @endforeach
@endsection
<script>
    $(function(){
        $('.quxiao').click(function(){
            var g_id = $(this).parents('table').attr('g_id');
            $.get(
              '/quxiao',
                {g_id:g_id},
                function(res){
                    alert(res.font);
                    if(res.code==1){
                        location.href="/collect";
                    }
                },
                'json'
            );
        })
    })
</script>