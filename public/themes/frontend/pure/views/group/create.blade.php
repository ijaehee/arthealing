@extends('layouts/adminLayout') 
<?php
Asset::queue('GroupController','js/GroupController.js','jquery') ; 
?>
@section('content')
<div class="container"> 
    <div class="row">
    <?php if(empty($group)): ?>
        <h2>그룹생성</h2>
    <?php else : ?>
        <h2>그룹수정</h2>
    <?php endif ; ?>
    </div>
    <div class="row">
        <form id="reg_form" class="form" method="post" action="/group/create">
            <input type="hidden" name="id" value="<?=@$group->id;?>"/>
            <div class="form-group">
                <label>GroupName </label>
                <input type="text" class="form-control" name="groupname" value="<?=@$group->name;?>" placeholder="Group Name" />
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
            <?php if(empty($group)): ?>
                <button type="submit" class="btn btn-primary">Save</button>
            <?php else : ?>
                <a class="btn btn-primary btn_modify">수정</a>
            <?php endif ; ?>
            </div>
            <div class="form-group pull-left">
                <a class="btn btn-default" href="/group/list">목록</a>
            </div>
        </form>
    </div>
</div>
@stop
