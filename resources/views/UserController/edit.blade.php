<form action="update" method="post" enctype="multipart/form-data">
    {{csrf_field()}}
    <input type="hidden" value="{{$data->id}}" name="id">
    姓名：<input type="text" name="name" value="{{$data->name}}"><br>
    年龄：<input type="number" name="sex" value="{{$data->sex}}"><br>
    头像：<input type="file" name="file"><br>
    <img src="http://images.wei.com/{{$data->file}}" width="50"><br>
    <input type="submit" value="修改">
</form>