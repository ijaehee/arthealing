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
        <form id="login_form" class="form" method="post" action="/login">
            <div class="control-groups">
                <label class="control-label">Email </label>
                <div lass="controls">
                    <input type="email" name="email" value="" placeholder="Email" />
                </div>
            </div>
            <div class="control-groups">
                <label class="control-label">Password </label>
                <div lass="controls">
                    <input type="password" name="password" value="" placeholder="Password" />
                </div>
            </div>
            <hr>
            <div class="text-center well" style="background-color:#efefef;"><?=@$msg;?></div>
            <div class="control-groups pull-right">
                <a class="btn btn-success" href="/signup">회원가입</a>
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
        </form>
    </div>
</div>
@stop
