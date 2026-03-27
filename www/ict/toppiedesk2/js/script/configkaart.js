//zonder deze aanroep werken er sommige dingen niet
$(function(){
    $('document').ready(function(){
        $('.js_delete').click(function(){
            if(confirm("Weet je zeker dat dit item wilt verwijderen bij deze gebruiker?"))
            {
                $.get("./js/ajax/hardwareRemove.php",{type:'single',name:$("input[name='searchoid']").val(),oid:this.name});
                $(this).ajaxComplete(function(){
                    return true;
                });
            }
            else return false;

        });
        
        $('a[name="archive"]').click(function(){
            if(confirm("Weet je zeker dat je alle items wilt verwijderen bij deze gebruiker?"))
            {
                $.get("./js/ajax/hardwareRemove.php",{type:'all',name:$("input[name='searchoid']").val()});
                $(this).ajaxComplete(function(){
                    return true;
                });
            }
            else return false;

        });
    });
});