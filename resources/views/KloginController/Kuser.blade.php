<h3>个人中心</h3>
<table border="1">
    <tr>
        <td>用户名</td>
        <td>注册时间</td>
    </tr>
    <tr>
        <td>{{$user->u_email}}</td>
        <td>{{date('Y-m-d h:i:s',$user->u_time)}}</td>
    </tr>
</table>