$(document).ready(function(){
    $('select[name=search_group]').change(function() {
        $('#search_form').submit(); 
    });    

    $('input[name=search_emil]').bind('keydown',function(l) {
        if(l.keyCode == 13){
            $('#search_form').submit(); 
        }
    });
    /*
    $('#reg_form').submit(function(e)  {
        $('input[name=email]').each(function() {
            var email = $(this);
            var validation = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i;
            if(!validation.test(email.val())){ 
                e.preventDefault(); 
                return false;
            }
        });    
    });
    */
}); 
