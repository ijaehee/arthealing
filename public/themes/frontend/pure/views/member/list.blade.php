@extends('layouts/adminLayout') 
<?php
Asset::queue('MemberController','js/MemberController.js','jquery') ; 
?>
@section('content')
<div class="container"> 
    <div class="row">
        <h2>회원목록</h2>
    </div>
    <div class="row" style="margin-bottom:10px;">
        <form method="get" id="search_form" action="/member/list" class="form-inline">
            <input class="form-control" style="width:220px;" name="search_email" value="<?=$selected_email;?>" placeholder="Input search email address">
            <select class="form-control" style="width:180px;" name="search_group">
                <option value="">모두</option>
                <?php foreach($groups as $key => $group) :?>
                <option <?php if($selected_group == $group->id){echo 'selected'; }?> value="<?=$group->id;?>"><?=$group->name;?></option>
                <?php endforeach;?>
            </select> 
        </form>
    </div>
    <div class="row">
        <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>번호</th>
                    <th>이메일</th>
                    <th>이름</th>
                    <th>생성날짜</th>
                    <th>기능</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($users)){ ?>
                <tr class="text-center">
                    <td colspan="5">회원이 없습니다.</td>
                </tr>
                <?php }else{ ?>
                <?php foreach($users as $key => $user) :?>
                <tr>  
                    <td><?=$user->id;?></td>
                    <td><a href="/member/modify/<?=$user->id;?>"><?=$user->email;?></a></td>
                    <td><?=$user->first_name;?></td>
                    <td><?=$user->created_at;?></td>
                    <td><a class="btn btn-danger" href="/member/delete/<?=$user->id;?>">삭제</a></td>
                </tr>  
                <?php endforeach;?>
                <?php }?>
            </tbody>
        </table>
    </div>
    <?php
        if($pagination['pageCount'] >= 5){
            $firstPage = $pagination['page'] > 3 ? $pagination['page'] - 2 : 1;
            $lastPage = $pagination['page'] > 3 ? $pagination['page'] + 2 : 5;
            if($lastPage > $pagination['pageCount']){
                $lastPage = $pagination['pageCount'];
                if(($lastPage % 5) != 0){
                    $temp = 5 - ($lastPage % 5);
                    $firstPage = $lastPage - ($temp + 1);
                }else{
                    $firstPage = $lastPage - 4;
                }
            }
        }else{
            $firstPage = 1;
            $lastPage = $pagination['pageCount'];
        }
    ?>  
    <div class="row">
        <div class="paging text-center">
            <ul class="pagination">
                <?php if(($pagination['page']) == 1):?> 
                <li class="disabled"><span>First</span></li>
                <li class="disabled"><span>&laquo;</span></li>
                <?php else:?> 
                <li><a href="/program/list/1"><span>First</span></a></li>
                <li><a href="/program/list/<?=$pagination['page']-1?>"><span>&laquo;</span></a></li>
                <?php endif;?>
                <?php for($i=$firstPage ; $i <$pagination['page'];$i++):?>
                <li><a href="/program/list/<?=$i?>"><span><?=$i?></span></a></li>
                <?php endfor;?>
                <li class="active"><a href="/program/list/<?=$pagination['page'];?>"><span><?=$pagination['page'];?></span></a></li>
                <?php for($i=$pagination['page']+1 ; $i <= $lastPage;$i++):?>
                <li><a href="/program/list/<?=$i?>"><span><?=$i?></span></a></li>
                <?php endfor;?>
                <?php if(($pagination['page']+1) <= $lastPage):?> 
                <li><a href="/program/list/<?=$pagination['page']+1?>"><span>&raquo;</span></a></li>
                <li><a href="/program/list/<?=$lastPage?>"><span>Last</span></a></li>
                <?php else:?> 
                <li class="disabled"><span>&raquo;</span></li>
                <li class="disabled"><span>Last</span></li>
                <?php endif;?>
            </ul>
        </div>
    </div>
</div>
@stop
