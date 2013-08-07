@extends('layouts/adminLayout') 
<?php
Asset::queue('MemberController','js/MemberController.js','jquery') ; 
?>
@section('content')
<div class="container"> 
    <div class="row">
        <h2>프로그램목록</h2>
    </div>
    <div class="row">
        <a class="btn btn-info pull-right" href="/register/create">프로그램생성</a>
    </div>
    <br>
    <div class="row">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>번호</th>
                    <th>프로그램이미지</th>
                    <th>프로그램이름</th>
                    <th>투어날짜</th>
                    <th>등록수</th>
                    <th>생성날짜</th>
                    <th>Hit</th>
                    <th>활성화유무</th>
                    <th>기능</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($result['registers'])){ ?>
                <tr class="text-center">
                    <td colspan="9">등록이 없습니다.</td>
                </tr>
                <?php }else{ ?>
                <?php foreach($result['registers'] as $key => $register) :?>
                <tr>  
                    <td><?=$register->id;?></td>
                    <td><a href="/register/modify/<?=$register->id;?>"><img src="<?=$register->main_src;?>"></a></td>
                    <td><?=$register->name;?></td>
                    <td><?=$register->due_date;?></td>
                    <td><?=$register->register_people?>/<?=$register->limit_people?></td>
                    <td><?=$register->created_at;?></td>
                    <td><?=$register->hit;?></td>
                    <td>
                        <?php if($register->activated == 1) : ?>
                        <a class="btn btn-success" href="/register/inactivated/<?=$register->id;?>">활성화</a>
                        <?php else : ?>
                        <a class="btn btn-default" href="/register/activated/<?=$register->id;?>">비활성화</a>
                        <?php endif ; ?>
                    </td>
                    <td><a class="btn btn-danger" href="/register/delete/<?=$register->id;?>">삭제</a></td>
                </tr>  
                <?php endforeach;?>
                <?php }?>
            </tbody>
        </table>
    </div>
</div>
@stop
