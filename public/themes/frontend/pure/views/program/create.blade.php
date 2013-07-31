@extends('layouts/pureLayout') 
<?php
Asset::queue('MemberController','js/MemberController.js','jquery') ; 
?>
@section('content')
<div class="container"> 
    <div style="">
        <div class="text-center">
            <h2>프로그램생성</h2>
        </div>
        <form id="reg_form" class="form" method="post" action="/program/create" enctype="multipart/form-data">
            <div class="control-groups">
                <label class="control-label">ProgramName </label>
                <div lass="controls">
                    <input type="text" name="programname" value="" placeholder="Program Name" />
                </div>
            </div>
            <div class="control-groups">
                <label class="control-label">Category </label>
                <div lass="controls">
                    <select name="category">
                        <option value="1">아트힐링</option>
                        <option value="2">호텔힐링</option>
                        <option value="3">자연힐링</option>
                        <option value="4">이벤트힐링</option>
                    </select>
                </div>
            </div>
            <div class="control-groups">
                <label class="control-label">Exhition </label>
                <div lass="controls">
                    <select name="exhibition">
                        <option value="1">김구림전</option>
                    </select>
                </div>
            </div>
            <div class="control-groups">
                <label class="control-label">Place </label>
                <div lass="controls">
                    <input type="text" name="place" value="" placeholder="Place" />
                </div>
            </div>
            <div class="control-groups">
                <label class="control-label">MainImage </label>
                <div lass="controls">
                    <input type="file" name="main_image"/>
                </div>
            </div>
            <div class="control-groups">
                <label class="control-label">SubImage </label>
                <div lass="controls">
                    <input type="file" name="sub_image"/>
                </div>
            </div>
            <div class="control-groups">
                <label class="control-label">Content </label>
                <div lass="controls">
                    <textarea type="file" name="content" class="ckeditor" style="width:100%; height:200px;"/></textarea>
                </div>
            </div>
            <hr>
            <div class="text-center alert <?php if(@$success == '1'){ echo 'alert-success';}else if(@$success == '2'){ echo 'alert-danger';}else{ echo 'alert-info';}?>"><?=@$msg;?></div>
            <div class="control-groups pull-right">
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
            <div class="control-groups pull-left">
                <a class="btn btn-default" href="/program/list">List</a>
            </div>
        </form>
    </div>
</div>
<script src="/themes/frontend/pure/assets/ckeditor/ckeditor.js"></script>
@stop
