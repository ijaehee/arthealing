@extends('layouts/pureLayout') 
<?php
Asset::queue('MemberController','js/MemberController.js','jquery') ; 
?>
@section('content')
<div class="container"> 
    <div class="row">
        <h2 style="text-align:center">투어목록</h2>
    </div>
    <div class="row">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>번호</th>
                    <th>프로그램이미지</th>
                    <th>프로그램이름</th>
                    <th>투어날짜</th>
                    <th>등록수</th>
                    <th>Hit</th>
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
                    <td><a href="/gate/apply/<?=$register->id;?>"><img src="<?=$register->main_src;?>"></a></td>
                    <td><?=$register->name;?></td>
                    <td><?=$register->due_date;?></td>
                    <td><?=$register->people;?></td>
                    <td><?=$register->people;?></td>
                </tr>  
                <?php endforeach;?>
                <?php }?>
            </tbody>
        </table>
    </div>
</div>
@stop
