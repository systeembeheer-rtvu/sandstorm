$(function(){
    $('a[name="archive"]').click(function(){
        if(confirm("Weet je zeker dat je dit status van het contract wilt aanpassen?"))
        {
            var val = $('input[name="oid"]').val();
            
            $.get("./js/ajax/contractremove.php", {contract:val})
            
            $(this).ajaxComplete(function(){
                location.reload();
            });
        }
        
        return false;
    });
    
    $('input[name="begindatum"]').datepicker({changeYear: true,dateFormat: 'dd-mm-yy',changeMonth: true, yearRange:'-5:+20' });
    $('input[name="einddatum"]').datepicker({changeYear: true,dateFormat: 'dd-mm-yy',changeMonth: true, yearRange:'-5:+20' });
});