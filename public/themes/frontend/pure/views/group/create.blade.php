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
            <div class="control-groups">
                <label class="control-label">GroupName </label>
                <div lass="controls">
                    <input type="text" name="groupname" value="" placeholder="Group Name" />
                </div>
            </div>
            <div class="control-groups">
                <label class="control-label">Permissions </label>
                <div class="controls">
                    <label class="checkbox-inline">
                        <input type="checkbox" name="permissions[]" value="admin">Admin
                    </label>
                    <label class="checkbox-inline">
                        <input type="checkbox" name="permissions[]" value="users">Users
                    </label>
                </div>
            </div>
            <hr>
            <div class="text-center well" style="background-color:#efefef;"><?=@$msg;?></div>
            <div class="control-groups pull-right">
                <button type="submit" class="btn btn-primary">Sign Up</button>
            </div>
            <div class="control-groups pull-left">
                <a class="btn btn-default" href="/group/list">목록</a>
            </div>
        </form>
    </div>
</div>
@stop
