//zonder deze aanroep werken er sommige dingen niet
$(function(){
    var userInfo;
    var categorieen;
    
    var oid = -1;
    
    $('#img img').preload({
        placeholder:'img/empty.png',
        notFound:'img/empty.png'
    });
    
    $('document').ready(function(){
        var counter = 0;
        
        if($('.naam').val() == "")
            $('#gebruiker').attr("disabled", "true");
        $('#asset').attr("disabled", "true");
        $('#email').hide();
        
        $.getJSON('./js/ajax/gebruikers.php',function(data){
            userInfo = data;
            
            if($('.naam').val() != "")
            {
                $.each(userInfo['gebruikers'], function(index, value){
                    if(value['naam'] == $('.naam').val())
                    {
                        setImg(value['inlognaam'],value['naam'],value['id']);
                    }
                });
            }
            else if($('.naam').val() == "")
            {
                $('#afdeling').val("");
            }
        });
        
        $.getJSON('./js/ajax/categorie.php', function(data){
            categorieen = data;
        });
        
        $('.tel').blur(function(){
            $.each(userInfo['gebruikers'], function(index, value){
                if($('.tel').val() == value['telefoonnummer'] && $('.tel').val() != "")
                {
                    $('.naam').val(value['naam']);
                    $('#afdeling').val(value['afdeling']);
                    setImg(value['inlognaam'],value['naam'],value['id']);
                    $('#gebruiker').removeAttr("disabled");
                }
            });
        });
        
        $('#dataform').keypress(function(event){
            if (event.which == '13' && $('input[name="naam"]').is(":focus")) {
                return false
            }
            
            return true;
        })
        
        $('.naam').blur(function()
        {
            var found = false;
           
            $.each(userInfo['gebruikers'], function(index, value){
                if(value['naam'] != undefined && $('.naam').val().toLowerCase() == value['naam'].toLowerCase() && $('.naam').val() != "")
                {
                    $('.naam').val(value['naam']);
                    if($('.tel').val() == "")
                        $('.tel').val(value['telefoonnummer']);
                    $('#afdeling').val(value['afdeling']);
                    
                    setImg(value['inlognaam'],value['naam'],value['id']);
                    
                    found = true;
                }
            });
            
            if(!found)
                $('#img').html("");
            
            if($('.naam').val() == "")
                $('#gebruiker').attr("disabled", "true");
            else
                $('#gebruiker').removeAttr("disabled");
        });
        
        $('a[name="print"]').click(function(){
            window.open('toppiedesk.php?id=callprint&searchoid=' + $('input[name="oid"]').val(), 'Incidenten_van_gebruiker');
        });
        
        $('#gebruiker').click(function(){
            window.open('toppiedesk.php?id=stats&stat=incidentenpergebruiker&naam=' + $('.naam').val() + '&submit=Toon', 'Incidenten_van_gebruiker');
        });
        
        $('a[name="save"]').click(function(){
            if(checkCategorie()){
               $('#dataform').submit();
            }
            
            return false;
        });
        
        $('input[name="opslaan"]').click(function(){
            if(checkCategorie()){
                return true;
            }
            
            return false;
        });
        
        $('input[name="o&a"]').click(function(){
            $('input[name="afgemeld"]').attr('checked', true);
            if(checkCategorie()){
                return true;
            }
            
            return false;
        });
        
        $('a[name="mail"]').click(function(data)
        {
            $('body').append(
                "<div id=\"email\">" +
                    "<div id=\"innerEmail\">" +
                        "<input type=\"radio\" checked=\"checked\" name=\"type\" value=\"ict\" id=\"ict\" />" +
                        "<label for=\"ict\">ICT</label><br />" +
                        "<input type=\"radio\" name=\"type\" value=\"aanmelder\" id=\"aanmelder\" />" +
                        "<label for=\"aanmelder\">Aanmelder</label><br />" +
                        "<input type=\"button\" name=\"genereren\" value=\"Genereer mail\" />" +
                        "<input type=\"button\" name=\"annuleren\" value=\"annuleren\" />" +
                    "</div>" +
                "</div>"
            );
            
            $('#innerEmail').css("left", data.clientX);
            $('#innerEmail').css("top", data.clientY);
            
            $('input[name="annuleren"]').click(function(){
                $('#email').remove();
            });
            
            $('input[name="genereren"]').click(function(){
                var temp = $('input[name="type"]:checked').val();
                if($('input[name="type"]:checked').val() == "ict")
                    ictmail();
                else if($('input[name="type"]:checked').val() == "aanmelder")
                    aanmeldermail();
                
                $('#email').remove();
            });
            
            return false;
        });
        
        function ictmail()
        {
            var invoerder = $('.js_behandelaar').html();
            if(invoerder == null)
            {
                invoerder = "";
            }
            
            var klant = $('input[name="naam"]').val();
            var telefoonnummer = $('input[name="tel"]').val();
            var aangemeld = $('.js_tijd').html();
            var categorie = $('label[for="' + $('input[name="categorie"]').attr('id') + '"]').html();
            var melding = $('textarea[name="probleem"]').val();
            
            if(aangemeld == null)
                aangemeld = "";
            
            var mailto = 'ict@rtvutrecht.nl';
            var subject = "(Toppiedesk) " + melding.substring(0,100);
            var body = "";
            
            body = 
                "Invoerder: " + invoerder + "%0A" +
                "Klant: " + klant + "%0A" + 
                "Telefoonnummer: " + telefoonnummer + "%0A" +
                "Aangemeld op: " + aangemeld + "%0A" +
                "categorie: " + categorie + "%0A" +
                "Melding: " + melding ;
                
            window.location.href = 'mailto:' + mailto + "?subject=" + subject + "&body=" + body;
        }
        
        function aanmeldermail()
        {
            var invoerder = $('.js_behandelaar').html();
            if(invoerder == null)
            {
                invoerder = "";
            }
            
            var klant = $('input[name="naam"]').val();
            var telefoonnummer = $('input[name="tel"]').val();
            var aangemeld = $('.js_tijd').html();
            var categorie = $('label[for="' + $('input[name="categorie"]').attr('id') + '"]').html();
            var melding = $('textarea[name="probleem"]').val();
            
            if(aangemeld == null)
                aangemeld = "";
            
            var mailto = '';
            var subject = "(Toppiedesk) " + melding.substring(0,100);
            var body = "";
            
            body = 
                "Invoerder: " + invoerder + "%0A" +
                "Klant: " + klant + "%0A" + 
                "Telefoonnummer: " + telefoonnummer + "%0A" +
                "Aangemeld op: " + aangemeld + "%0A" +
                "categorie: " + categorie + "%0A" +
                "Melding: " + melding ;
            
            window.location.href = 'mailto:' + mailto + "?subject=" + subject + "&body=" + body;
        }
        
        function checkCategorie()
        {
            var categorie = $('input[name="categorie"]:checked').val();
            var categorietekst = $('input[name="probleemtekst"]').val();
            
            if(categorie == 0 && categorietekst == "")
            {
                $('input[name="probleemtekst"]').css("background-color","Red");
                counter++;
                
                if(counter < 2)
                    return false;
            }
            
            return true;
        }
        
        function setImg(inlognaam, naam, id)
        {
            if(id == null || inlognaam == null)
                $('#img').html('<img src="http://intranet/ict/toppiedesk2/img/empty.png"');
            else
                $('#img').html('<a href="http://intranet/smoelenboek/weergeven.php?id=' + id + '"><img src="http://intranet/smoelenboek/smoelenfotos/' + inlognaam + '.jpg" height="100" width="100" title="' + naam + '"></a>');
        }
    });
});