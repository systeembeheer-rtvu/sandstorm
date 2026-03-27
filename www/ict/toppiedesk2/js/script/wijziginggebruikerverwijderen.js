//zonder deze aanroep werken er sommige dingen niet
$(function(){
    $('document').ready(function(){
        $('img').click(function(){
            $.get("./js/ajax/useraccount.php", {"id":$(this).attr("alt"), "actie":"verwijderen" });
            location.reload();

        });
    });
});