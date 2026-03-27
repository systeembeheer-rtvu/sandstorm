//zonder deze aanroep werken er sommige dingen niet
$(function(){
    $('document').ready(function(){
        $('input[name="open"]').click(function(){
            var open;
            
            if($('input[name="open"]').is(':checked'))
                open="&open=on";
            else
                open= "";
            
            window.location.replace("turbodesk.php?id=calloverzicht&versturen=Toon" + open);
        });
    });
});