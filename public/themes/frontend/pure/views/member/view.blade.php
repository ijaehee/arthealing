@extends('layouts/pureLayout') 
<?php
Asset::queue('MemberController','js/MemberController.js','jquery') ; 
?>
@section('content')
<div class="container"> 
    <div style="width:500px;margin:0 auto;">
        <div class="text-center">
            <h2>회원정보</h2>
        </div>
        <form id="info_form" class="form" method="post" action="/member/modify">
            <input type="hidden" name="id" value="<?=@$user->id;?>"/>
            <div class="control-groups">
                <label class="control-label">Email </label>
                <div lass="controls">
                <input type="email" name="email" value="<?=@$user->email;?>" placeholder="Email" disabled/>
                </div>
            </div>
            <div class="control-groups">
                <label class="control-label">Name </label>
                <div lass="controls">
                    <input type="text" name="username" value="<?=@$user->first_name;?>" placeholder="Name" />
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
            <div class="control-groups pull-right">
                <a class="btn btn-default" href="/member/list">목록</a>
                <button type="submit" class="btn btn-primary">수정</button>
            </div>
        </form>
    </div>
</div>
@stop
