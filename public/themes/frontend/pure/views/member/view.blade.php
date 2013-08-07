@extends('layouts/adminLayout') 
<?php
Asset::queue('MemberController','js/MemberController.js','jquery') ; 
?>
@section('content')
<div class="container"> 
    <div class="row">
        <div>
            <h2>회원정보</h2>
        </div>
        <form id="info_form" method="post" action="/member/modify">
            <input type="hidden" name="id" value="<?=@$user->id;?>"/>
            <div class="form-group">
                <label>Email </label>
                <div lass="controls">
                <input type="email" class="form-control" name="email" value="<?=@$user->email;?>" placeholder="Email" disabled/>
                </div>
            </div>
            <div class="form-group">
                <label>Name </label>
                <div lass="controls">
                    <input type="text" class="form-control" name="username" value="<?=@$user->first_name;?>" placeholder="Name" />
                </div>
            </div>
            <div class="form-group">
                <label>Password </label>
                <div lass="controls">
                    <input type="password" class="form-control" name="password" value="" placeholder="Password" />
                </div>
            </div>
            <div class="form-group">
                <label>Password Confirm </label>
                <div lass="controls">
                    <input type="password" class="form-control" name="password_conf" value="" placeholder="Password Confirm" />
                </div>
            </div>
            <hr>
            <div class="form-group pull-right">
                <a class="btn btn-default" href="/member/list">목록</a>
                <button type="submit" class="btn btn-primary">수정</button>
            </div>
        </form>
    </div>
</div>
@stop
