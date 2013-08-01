$(document).ready(function(){
    $('.datepicker').datepicker({
        dateFormat : 'yy-mm-dd'
    });

    $('.btn_modify').bind('click',function(){
        $('#reg_form').attr('action','/register/modify').submit();
    });
}); 
