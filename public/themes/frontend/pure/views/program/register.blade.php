@extends('layouts/adminLayout') 
<?php
Asset::queue('ProgramController','js/ProgramController.js','jquery') ; 
?>
@section('content')
<div class="container"> 
    <div class="row">
        <?php if(empty($program)): ?>
        <h2>프로그램생성</h2>
        <?php else : ?>
        <h2>프로그램수정</h2>
        <?php endif ; ?>
    </div>
    <form id="reg_form" class="form" method="post" action="/program/create" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?=@$program->id;?>"/>
        <div class="form-group">
            <label >ProgramName </label>
            <input type="text" class="form-control" name="programname" value="<?=@$program->name;?>" placeholder="Program Name" />
        </div>
        <div class="form-group">
            <label>Category </label>
            <select class="form-control" name="category">
                <option value="1" <?php if(@$program->category=="1"){?>selected<?php }?>>아트힐링</option>
                <option value="2" <?php if(@$program->category=="2"){?>selected<?php }?>>호텔힐링</option>
                <option value="3" <?php if(@$program->category=="3"){?>selected<?php }?>>자연힐링</option>
                <option value="4" <?php if(@$program->category=="4"){?>selected<?php }?>>이벤트힐링</option>
            </select>
        </div>
        <div class="form-group">
            <label>Exhition </label>
            <select class="form-control" name="exhibition">
                <option value="1" <?php if(@$program->exhibiton=="1"){?>selected<?php }?>>김구림전</option>
            </select>
        </div>
        <div class="form-group">
            <label>Place </label>
            <input type="text" class="form-control" name="place" value="<?=@$program->place;?>" placeholder="Place" />
        </div>
        <div class="form-group">
            <label>MainImage </label>
            <input type="file" name="main_image"/>
        </div>
        <div class="form-group">
            <label>SubImage </label>
            <input type="file" name="sub_image"/>
        </div>
        <div class="form-group">
            <label>Content </label>
            <textarea type="file" name="content" class="ckeditor" style="width:100%; height:200px;"/><?=@$program->content;?></textarea>
        </div>
        <hr>
        <div class="text-center alert <?php if(@$error == '1'){ echo 'alert-success';}else if(@$error == '2'){ echo 'alert-danger';}else{ echo 'alert-info';}?>"><?=@$msg;?></div>
        <div class="form-group pull-right">
            <?php if(empty($program)): ?>
            <button type="submit" class="btn btn-primary">Create</button>
            <?php else : ?>
            <a class="btn btn-primary btn_modify">수정</a>
            <?php endif ; ?>
        </div>
        <div class="form-group pull-left">
            <a class="btn btn-default" href="/program/list">List</a>
        </div>
    </form>
</div>
<script src="/themes/frontend/pure/assets/ckeditor/ckeditor.js"></script>
@stop
