@extends('layouts/pureLayout') 
<?php
Asset::queue('MemberController','js/MemberController.js','jquery') ; 
?>
@section('content')
<div class="container"> 
    <div class="row">
        <h2 style="text-align:center">프로그램목록</h2>
    </div>
    <div class="row">
        <a class="btn btn-info pull-right" href="/program/create">프로그램생성</a>
    </div>
    <br>
    <div class="row">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>번호</th>
                    <th>프로그램이미지</th>
                    <th>프로그램이름</th>
                    <th>생성날짜</th>
                    <th>기능</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($result['programs'])){ ?>
                <tr class="text-center">
                    <td colspan="5">프로그램이 없습니다.</td>
                </tr>
                <?php }else{ ?>
                <?php foreach($result['programs'] as $key => $program) :?>
                <tr>  
                    <td><?=$program->id;?></td>
                    <td><img src="<?=$program->main_src;?>"></td>
                    <td><?=$program->name;?></td>
                    <td><?=$program->created_at;?></td>
                    <td><a class="btn btn-danger" href="/program/delete/<?=$program->id;?>">삭제</a></td>
                </tr>  
                <?php endforeach;?>
                <?php }?>
            </tbody>
        </table>
    </div>
</div>
@stop
