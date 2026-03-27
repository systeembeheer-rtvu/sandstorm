//zonder deze aanroep werken er sommige dingen niet
$(function(){   
    $('document').ready(function(){
        $('#fout').hide();
        
        $("#gebdat").datepicker({changeYear: true,dateFormat: 'dd-mm-yy',yearRange:'-65:+1',changeMonth: true });
        $("#begindatum").datepicker({dateFormat: 'dd-mm-yy',yearRange:'-1:+2',changeMonth: true });
        
        $('input[name="submit"]').click(function(){
            var voornaam = $('input[name="voornaam"]').val();
            var tussenvoegsel = $('input[name="tussenvoegsel"]').val();
            var achternaam = $('input[name="achternaam"]').val();
            var adres = $('input[name="adres"]').val();
            var postcode = $('input[name="postcode"]').val();
            var plaats = $('input[name="plaats"]').val();
            var bdatum = $('input[name="begindatum"]').val();
            var gebdat = $('input[name="gebdat"]').val();
            var afdeling = $('select[name="afdeling"]').val();
            
            var error = "";
            
            if(voornaam == "")
            {
                error +="- De voornaam is niet geldig<br />";
                $('input[name="voornaam"]').css("background-color", "red");
            }
            else
            {
                $('input[name="voornaam"]').css("background-color", "white");
            }
            
            if(achternaam == "")
            {
                error += "- De achternaam is niet geldig<br />";
                $('input[name="achternaam"]').css("background-color", "red");
            }
            else
            {
                $('input[name="achternaam"]').css("background-color", "white");
            }
            
            if(adres == "")
            {
                error += "- Het adres is niet geldig<br />";
                $('input[name="adres"]').css("background-color", "red");
            }
            else
            {
                $('input[name="adres"]').css("background-color", "white");
            }
            
            if(postcode == "")
            {
                error += "- De postcode is niet geldig<br />";
                $('input[name="postcode"]').css("background-color", "red");
            }
            else
            {
                $('input[name="postcode"]').css("background-color", "white");
            }
            
            if(plaats == "")
            {
                error += "- De plaats is niet geldig<br />";
                $('input[name="plaats"]').css("background-color", "red");
            }
            else
            {
                $('input[name="plaats"]').css("background-color", "white");
            }
            
            
            if (!/^(?:(0[1-9]|[12][0-9]|3[01])-(0[1-9]|1[012])-(19|20)[0-9]{2})$/.test(bdatum)) {
                error += "- De begin datum is niet geldig<br />";
                $('input[name="begindatum"]').css("background-color", "red");
            }
            else
            {
                $('input[name="begindatum"]').css("background-color", "white");
            }
            
            if (!/^(?:(0[1-9]|[12][0-9]|3[01])-(0[1-9]|1[012])-(19|20)[0-9]{2})$/.test(gebdat)) {
                error += "- De geboorte datum is niet geldig<br />";
                $('input[name="gebdat"]').css("background-color", "red");
            }
            else
            {
                $('input[name="gebdat"]').css("background-color", "white");
            }
            
            if(afdeling == 0)
            {
                error += "- Er is geen afdeling gekozen";
                $('select[name="afdeling"]').css("background-color", "red");
            }
            else
            {
                $('select[name="afdeling"]').css("background-color", "white");
            }
            
            if(error != "")
            {
                $('#succes').hide();
                error = "Niet alle velden zijn goed ingevuld:<br />" + error;
                $('#fout>p').html(error);
                $('#fout').fadeIn();
                
                return false;
            }
            
            return true;
        });
    });
});