<link rel="stylesheet" href="{{asset('css/page.css')}}">
<form action="index" method="get">
    <input type="text" name="name" value=""><br>
    <input type="submit" value="搜索">
</form>
<table border="1">
    <tr>
        <td>排序</td>
        <td>网站名称</td>
        <td>图片LOGO</td>
        <td>链接类型</td>
        <td>状态</td>
        <td colspan="2">管理操作</td>
    </tr>
    @foreach($data as $k=>$v)
        <tr>
            <td>{{$v->id}}</td>
            <td>{{$v->name}}</td>
            <td><img src="http://images.wei.com/{{$v->logo}}" width="50"></td>
            <td>{{$v->type}}</td>
            <td>{{$v->show}}</td>
            {{--route相对路径函数--}}
            <td><a href="{{route('del',['id'=>$v->id])}}">删除</a></td>
            {{--url绝对路径函数--}}
            <td><a href="{{url('BlogrollController/edit',[$v->id])}}">修改</a></td>
        </tr>
    @endforeach
    <tr>
        {{--分页页码--}}
        <td colspan="7">{{ $data->appends($query)->links() }}</td>
    </tr>
</table>