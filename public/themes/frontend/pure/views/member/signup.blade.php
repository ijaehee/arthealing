@extends('layouts/pureLayout') 
<?php
Asset::queue('MemberController','js/MemberController.js','jquery') ; 
?>
@section('content')
<div class="container"> 
    <div style="width:500px;margin:0 auto;">
        <div class="text-center">
            <h2>회원가입</h2>
        </div>
        <form id="reg_form" method="post" action="/signup">
            <div class="form-group">
                <label>Email </label>
                <input type="email" class="form-control" name="email" value="" placeholder="Email" />
            </div>
            <div class="form-group">
                <label>Name </label>
                <input type="text" class="form-control" name="username" value="" placeholder="Name" />
            </div>
            <div class="form-group">
                <label>Password </label>
                <input type="password" class="form-control" name="password" value="" placeholder="Password" />
            </div>
            <div class="form-group">
                <label>Password Confirm </label>
                <input type="password" class="form-control" name="password_conf" value="" placeholder="Password Confirm" />
            </div>
            <hr>
            <div class="text-center well" style="background-color:#efefef;"><?=@$msg;?></div>
            <div class="form-group pull-right">
                <button type="submit" class="btn btn-primary">Sign Up</button>
            </div>
        </form>
    </div>
</div>
@stop
