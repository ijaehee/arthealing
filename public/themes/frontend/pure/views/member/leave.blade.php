@extends('layouts/pureLayout') 
<?php
Asset::queue('MemberController','js/MemberController.js','jquery') ; 
?>
@section('content')
<div class="container"> 
    <div class="text-center">
        <h2>탈퇴신청</h2>
    </div>
    <div class="row">
        아래 회원탈퇴 관련 사황을 확인하시고, 해지신청을 하시면 소정의 확인절차를 통해 회원 탈퇴처리가 완료됩니다.
    </div>
    <br>
    <div class="row">
        <div class="alert alert-error">
            <strong>1. </strong>아이디와 함께 아트그라피에 존재하는 모든     정보가 영구적으로 삭제되어 복구되지 않습니다.
            <br>
            <br>
            <strong>2. </strong>아트그라피 및 기타 개인정보가 삭제됩니다    .
        </div>
    </div>
    <div class="row"> 
        <form id="leave_form" class="form" method="post" action="/member/leave">
            <div class="form-group">
                <label>Password </label>
                <input type="password" class="form-control" name="password" value="" placeholder="Password" />
            </div>
            <hr>
            <div class="text-center well" style="background-color:#efefef;"><?=@$msg;?></div>
            <div class="form-group pull-right">
                <button type="submit" class="btn btn-danger">탈퇴</button>
            </div>
        </form>
    </div>
</div>
@stop
