@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
<form action="/BlogrollController/loginDo" method="post">
    {{csrf_field()}}
    用户名：<input type="text" name="name"><br>
    密码：<input type="password" name="pwd"><br>
    登录：<input type="submit" value="登录"><br>
</form>