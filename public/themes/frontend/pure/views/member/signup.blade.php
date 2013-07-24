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
        <form id="reg_form" class="form" method="post" action="/signup">
            <div class="control-groups">
                <label class="control-label">Email </label>
                <div lass="controls">
                    <input type="email" name="email" value="" placeholder="Email" />
                </div>
            </div>
            <div class="control-groups">
                <label class="control-label">Name </label>
                <div lass="controls">
                    <input type="text" name="username" value="" placeholder="Name" />
                </div>
            </div>
            <div class="control-groups">
                <label class="control-label">Password </label>
                <div lass="controls">
                    <input type="password" name="password" value="" placeholder="Password" />
                </div>
            </div>
            <div class="control-groups">
                <label class="control-label">Password Confirm </label>
                <div lass="controls">
                    <input type="password" name="password_conf" value="" placeholder="Password Confirm" />
                </div>
            </div>
            <hr>
            <div class="text-center well" style="background-color:#efefef;"><?=@$msg;?></div>
            <div class="control-groups pull-right">
                <button type="submit" class="btn btn-primary">Sign Up</button>
            </div>
        </form>
    </div>
</div>
@stop
