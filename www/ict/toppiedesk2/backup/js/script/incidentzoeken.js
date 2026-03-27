//zonder deze aanroep werken er sommige dingen niet
$(function(){
    $('document').ready(function(){
        
        $.getJSON('./js/ajax/gebruikers.php',function(data){
            userInfo = data;
        });
        
        $('.naam').blur(function(){
            $.each(userInfo['gebruikers'], function(index, value){
                if(value['naam'] != undefined && $('.naam').val().toLowerCase() == value['naam'].toLowerCase() && $('.naam').val() != "")
                    $('.naam').val(value['naam']);   
            });
        });
        
        if($('input[name="opdracht"]').val() != "")
            $('#resultaten').highlight($('input[name="opdracht"]').val());
    });
});
