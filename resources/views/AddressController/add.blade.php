<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="/js/jquery-3.1.1.min.js"></script>
@extends('layouts.layout')
@section('content')
    <form onsubmit="return false" method="get" class="reg-login">
        <div class="lrBox">
            <div class="lrList"><input type="text" name="add_name" placeholder="收货人" /></div>
            <div class="lrList"><input type="text" name="add_detail" placeholder="详细地址" /></div>
            <div class="lrList">
                <select name="probince" class="area">
                    <option>省份/直辖市</option>
                    @foreach($probince as $k=>$v)
                    <option value="{{$v->id}}">{{$v->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="lrList">
                <select name="city" class="area">
                    <option>区县</option>
                </select>
            </div>
            <div class="lrList">
                <select name="area" class="area">
                    <option>详细地址</option>
                </select>
            </div>
            <div class="lrList"><input type="text" name="add_tel" placeholder="手机" /></div>
            <div class="lrList2">
                <input type="checkbox" name="exist">
                    <button id="hui">是否默认</button>
            </div>
        </div><!--lrBox/-->
        <div class="lrSub">
            <input type="submit" id="save" value="保存" />
        </div>
    </form><!--reg-login/-->
@endsection
<script>
    $(function(){
        $('#hui').click(function(){
            location.href="/address/index";
        })
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
        $('#save').click(function(){
            var _obj = {};
            _obj.probince = $('select[name=probince]').val();
            _obj.city = $('select[name=city]').val();
            _obj.area = $('select[name=area]').val();
            _obj.add_name = $('input[name=add_name]').val();
            _obj.add_tel = $('input[name=add_tel]').val();
            _obj.add_detail = $('input[name=add_detail]').val();
            var exist = $('input[name=exist]').prop('checked');
            if(exist==true){
                _obj.add_exist=1;
            }else{
                _obj.add_exist=2;
            }
            if (_obj.province==''||_obj.city==''||_obj.area==''||_obj.add_name==''||
                _obj.add_tel==''||_obj.add_detail=='') {
                alert('请填写全部内容');
                return false;
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post(
                '/address/adddo',
                _obj,
                function(res){
                    alert(res.font);
                    location.href="/address/index";
                },
                'json'
            );
        });
    })
</script>