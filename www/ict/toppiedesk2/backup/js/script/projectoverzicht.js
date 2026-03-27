//zonder deze aanroep werken er sommige dingen niet
$(function(){
    $('document').ready(function(){
       $("input[name='print']").click(function(){
            window.open('toppiedesk.php?id=projectoverzichtprint&medewerker=' + $("input[name='Currentid']").val(), 'projectoverzicht');
        });
    });
});