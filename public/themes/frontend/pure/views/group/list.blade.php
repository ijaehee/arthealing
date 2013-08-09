@extends('layouts/adminLayout') 
<?php
Asset::queue('MemberController','js/MemberController.js','jquery') ; 
?>
@section('content')
<div class="container"> 
    <div class="row">
        <h2>그룹목록</h2>
    </div>
    <div class="row">
        <a class="btn btn-info pull-right" href="/group/form">그룹생성</a>
    </div>
    <br>
    <div class="row">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>번호</th>
                    <th>그룹이름</th>
                    <th>권한</th>
                    <th>생성날짜</th>
                    <th>기능</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($result['groups'])){ ?>
                <tr class="text-center">
                    <td colspan="5">그룹이 없습니다.</td>
                </tr>
                <?php }else{ ?>
                <?php foreach($result['groups'] as $key => $group) :?>
                <tr>  
                    <td><?=$group->id;?></td>
                    <td><a href="/group/form/<?=$group->id;?>"><?=$group->name;?></a></td>
                    <td><?php foreach($group->permissions as $key => $value)echo $key." ";?></td>
                    <td><?=$group->created_at;?></td>
                    <td><a class="btn btn-danger" href="/group/delete/<?=$group->id;?>">삭제</a></td>
                </tr>  
                <?php endforeach;?>
                <?php }?>
            </tbody>
        </table>
    </div>
</div>
@stop
