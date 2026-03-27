//zonder deze aanroep werken er sommige dingen niet
$(function(){
    $('document').ready(function(){
        $('#succes').hide();
        $('#fout').hide();
        
        $('#naam').blur(function(){
            $.get("./js/ajax/ftpname.php",  { naam:$('#naam').val()} , function(data){
                if(data > 0)
                {
                    $('#fout > p').html("Accountnaam bestaat al");
                    $('#naam').css("background","red");
                    $('#fout').fadeIn();
                    
                }
                else
                {
                    $('#naam').css("background","white");
                    $('#fout').fadeOut();
                }
            });
        });
        
        $('#ftp').submit(function(){
            var result = true;
            
            $.get("./js/ajax/ftpname.php",  { naam:$('#naam').val()} , function(data){
                if(data > 0)
                {
                    result = false;
                }
            });
            
            if($('#email').val() == "")
            {
                $('#fout > p').html("Geen e-mail adres ingevuld");
                $('#email').css("background","red");
                $('#fout').fadeIn();
                
                result = false;
            }
            
            return result;
        });
    });
});