$(document).ready(function(){
    $('.btn_modify').bind('click',function(){
        $('#reg_form').attr('action','/program/modify').submit();
    });
}); 
