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
        <form id="reg_form" class="form" method="post" action="/group/register">
            <div class="control-groups">
                <label class="control-label">GroupName </label>
                <div lass="controls">
                    <input type="text" name="groupname" value="" placeholder="Group Name" />
                </div>
            </div>
            <div class="control-groups">
                <label class="control-label">Permissions </label>
                <div lass="controls">
                    <input type="radio" name="permissions" value="admin">Admin
                    <input type="radio" name="permissions" value="users">Users
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
