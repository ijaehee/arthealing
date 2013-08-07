@extends('layouts/pureLayout') 
<?php
Asset::queue('MemberController','js/MemberController.js','jquery') ; 
?>
@section('content')
<div class="container"> 
    <div style="width:500px;margin:0 auto;">
        <div class="text-center">
            <h2>로그인</h2>
        </div>
        <form id="login_form" method="post" action="/login">
            <div class="form-group">
                <label>Email </label>
                <input type="email" class="form-control" name="email" value="" placeholder="Email" />
            </div>
            <div class="form-group">
                <label>Password </label>
                <input type="password" class="form-control" name="password" value="" placeholder="Password" />
            </div>
            <hr>
            <div class="text-center well" style="background-color:#efefef;"><?=@$msg;?></div>
            <div class="form-group pull-right">
                <a class="btn btn-success" href="/signup">회원가입</a>
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
        </form>
    </div>
</div>
@stop
