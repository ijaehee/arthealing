$(document).ready(function(){
    $('.btn_modify').bind('click',function(){
        $('#reg_form').attr('action','/group/modify').submit();
    });
}); 
