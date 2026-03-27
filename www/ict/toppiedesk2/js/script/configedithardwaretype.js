//zonder deze aanroep werken er sommige dingen niet
$(function(){
    $('document').ready(function(){
        $('input[name="aanmaken"]').click(function(){
            var naam = $('input[name="naam"]').val();
            
            $.getJSON("./js/ajax/edithardwaretype.php",{"type":naam})
            
            
            return false;
        });
    });
});