@extends('layouts/pureLayout') 
<?php
Asset::queue('RegisterController','js/RegisterController.js','jquery') ; 
Asset::queue('alias','js/jquery-ui.js','jquery') ; 
Asset::queue('alias','css/jquery-ui.css') ; 
?>
@section('content')
<div class="container"> 
    <div style="">
        <div class="text-center">
            <h2>신청서</h2>
        </div>
        <form id="app_form" class="form" method="post" action="/gate/apply">
                <input type="hidden" name="register_id" value="<?=@$register->id;?>"/>
            <div class="control-groups">
                <label class="control-label">ProgramName </label>
                <div lass="controls">
                    <input type="text" name="programname" value="<?=@$program->name;?>"/>
                </div>
            </div>
            <div class="control-groups">
                <label class="control-label">투어날짜 </label>
                <div lass="controls">
                    <input type="text" name="due_date" value="<?=@$register->due_date;?>"/>
                </div>
            </div>
            <div class="control-groups">
                <label class="control-label">Content </label>
                <div lass="controls">
                    <div><?=@$program->content;?></div>
                    <div><?=@$register->etc;?></div>
                </div>
            </div>
            <hr>
            <div class="control-groups pull-right">
                <button type="submit" class="btn btn-primary">Apply</button>
            </div>
            <div class="control-groups pull-left">
                <a class="btn btn-default" href="/gate/list">List</a>
            </div>
        </form>
    </div>
</div>
@stop
