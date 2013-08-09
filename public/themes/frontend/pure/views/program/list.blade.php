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
        <a class="btn btn-info pull-right" href="/program/form">프로그램생성</a>
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
                    <th>활성화유무</th>
                    <th>기능</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($programs)){ ?>
                <tr class="text-center">
                    <td colspan="5">프로그램이 없습니다.</td>
                </tr>
                <?php }else{ ?>
                <?php foreach($programs as $key => $program) :?>
                <tr>  
                    <td><?=$program->id;?></td>
                    <td><a href="/program/form/<?=$program->id;?>"><img src="<?=$program->main_src;?>"></a></td>
                    <td><?=$program->name;?></td>
                    <td><?=$program->created_at;?></td>
                    <td>
                    <?php if($program->activated == 1) : ?>
                        <a class="btn btn-success" href="/program/inactivated/<?=$program->id;?>">활성화</a>
                        <?php else : ?>
                        <a class="btn btn-default" href="/program/activated/<?=$program->id;?>">비활성화</a>
                    <?php endif ; ?>
                    </td>
                    <td><a class="btn btn-danger" href="/program/delete/<?=$program->id;?>">삭제</a></td>
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
