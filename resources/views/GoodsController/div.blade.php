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