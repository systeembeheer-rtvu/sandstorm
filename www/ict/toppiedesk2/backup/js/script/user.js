//zonder deze aanroep werken er sommige dingen niet
$(function() {
    $('document').ready(function({}){
        
        $.datepicker.setDefaults($.datepicker.regional['nl']);
        $("#gebdat").datepicker({changeYear: true,dateFormat: 'dd-mm-yy',yearRange:'-80:+0',changeMonth: true });
        
        $("#datumindienst").datepicker({changeMonth: true, dateFormat: 'dd-mm-yy'});
        
        $("form").submit(function(){
            var subvoor = $('input[name="voornaam"]').val().substring(0,3);
            var subachter = $('input[name="achternaam"]').val().substring(0,3);
            
            var loginname = subvoor + subachter
            loginname = loginname.toLowerCase();
            
            var temp = $('input[name="tussenvoegselafk"]').val();
            
            if(temp.length > 5)
            {
                $('input[name="tussenvoegselafk"]').css("background-color", "Red");
                return false;
            }
            
            var current = $('input[name="inlognaam"]').val().toLowerCase()
            
            if(loginname != current)
            {
                if(confirm("Moet de inlognaam ook verandert worden naar " + loginname + "?"))
                {
                    $('input[name="inlognaam"]').val(loginname);
                }
            }
            
            return true;
        })
    });
});