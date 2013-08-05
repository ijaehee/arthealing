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
        <?php if(empty($register)): ?>
            <h2>힐링생성</h2>
        <?php else : ?>
            <h2>힐링수정</h2>
        <?php endif ; ?>
        </div>
        <form id="reg_form" class="form" method="post" action="/register/create">
                <input type="hidden" name="id" value="<?=@$register->id;?>"/>
            <div class="control-groups">
                <label class="control-label">ProgramName </label>
                <div lass="controls">
                    <select name="program_id">
                    <?php foreach($programs as $key => $program) :?>
                        <option value="<?=@$program->id;?>" <?php if(@$register->program_id=="1"){?>selected<?php }?>><?=@$program->name;?></option>
                    <?php endforeach;?>
                    </select>
                </div>
            </div>
            <div class="control-groups">
                <label class="control-label">투어날짜 </label>
                <div lass="controls">
                    <input type="text" name="due_date" value="<?=@$register->due_date;?>" class="datepicker"/>
                </div>
            </div>
            <div class="control-groups">
                <label class="control-label">참가자수 </label>
                <div lass="controls">
                    <input type="text" name="limit_people" value="<?=@$register->limit_people;?>"/>
                </div>
            </div>
            <div class="control-groups">
                <label class="control-label">Content </label>
                <div lass="controls">
                    <textarea type="file" name="etc" class="ckeditor" style="width:100%; height:200px;"/><?=@$register->etc;?></textarea>
                </div>
            </div>
            <hr>
            <div class="text-center alert <?php if(@$success == '1'){ echo 'alert-success';}else if(@$success == '2'){ echo 'alert-danger';}else{ echo 'alert-info';}?>"><?=@$msg;?></div>
            <div class="control-groups pull-right">
            <?php if(empty($register)): ?>
                <button type="submit" class="btn btn-primary">Create</button>
            <?php else : ?>
                <a class="btn btn-primary btn_modify">수정</a>
            <?php endif ; ?>
            </div>
            <div class="control-groups pull-left">
                <a class="btn btn-default" href="/register/list">List</a>
            </div>
        </form>
    </div>
</div>
<script src="/themes/frontend/pure/assets/ckeditor/ckeditor.js"></script>
@stop
