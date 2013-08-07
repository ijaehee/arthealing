@extends('layouts/pureLayout') 
<?php
Asset::queue('MemberController','js/MemberController.js','jquery') ; 
?>
@section('content')
<div class="container"> 
    <div style="width:500px;margin:0 auto;">
        <div class="text-center">
            <h2>그룹생성</h2>
        </div>
        <form id="reg_form" class="form" method="post" action="/group/create">
            <div class="form-group">
                <label>GroupName </label>
                <input type="text" class="form-control" name="groupname" value="" placeholder="Group Name" />
            </div>
            <div class="form-group">
                <label class="control-label">Permissions </label>
                <label class="checkbox-inline">
                    <input type="checkbox" name="permissions[]" value="admin">Admin
                </label>
                <label class="checkbox-inline">
                    <input type="checkbox" name="permissions[]" value="users">Users
                </label>
            </div>
            <hr>
            <div class="text-center well" style="background-color:#efefef;"><?=@$msg;?></div>
            <div class="form-group pull-right">
                <button type="submit" class="btn btn-primary">Sign Up</button>
            </div>
            <div class="form-group pull-left">
                <a class="btn btn-default" href="/group/list">목록</a>
            </div>
        </form>
    </div>
</div>
@stop
