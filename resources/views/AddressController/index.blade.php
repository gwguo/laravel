<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="/js/jquery-3.1.1.min.js"></script>
@extends('layouts.layout')
@section('content')
<table class="shoucangtab">
    <tr>
        <td width="75%"><a href="/address/add" class="hui"><strong class="">+</strong> 新增收货地址</a></td>
        <td width="25%" align="center" style="background:#fff">
            <a href="javascript:;" class="orange">删除信息</a></td>
    </tr>
</table>

<div class="dingdanlist">
    <table>
        @foreach($address as $v)
        <tr>
            <td width="50%">
                <h3>{{$v->add_name}} {{$v->add_tel}}</h3>
                <i>{{$v->add_detail}}</i>
            </td>
            <td align="right"><a href="address.html" class="hui"><span class="glyphicon glyphicon-check"></span> 修改信息</a></td>
        </tr>
        @endforeach
    </table>
</div>
@endsection