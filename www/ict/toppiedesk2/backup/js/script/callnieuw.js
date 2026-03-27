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
	
	$(window).unload(function(){
	    if(window.opener.location.href.indexOf("id=calloverzicht") > 0 || window.opener.location.href.substr(-13) == "turbodesk.php")
	    {
		window.opener.location.href = window.opener.location.href;
		
		if (window.opener.progressWindow)
		{
		    window.opener.progressWindow.close()
		}
	    }
	});
	
	if($('input[name="oid"]').val() == 0)
	{
	    $('input[name="tel"]').focus();
	}
	else
	{
	    $('textarea[name="actie"]').focus();
	}
        
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
	    if($('.naam').val() == "")
	    {
		$.each(userInfo['gebruikers'], function(index, value){
		    if($('.tel').val() == value['telefoonnummer'] && $('.tel').val() != "")
		    {
			$('.naam').val(value['naam']);
			$('#afdeling').val(value['afdeling']);
			setImg(value['inlognaam'],value['naam'],value['id']);
			$('#gebruiker').removeAttr("disabled");
		    }
		});
	    }
        });
        
        $('input[name="asset"]').blur(function(){
            if($('input[name="asset"]').val())
            {
                $('#asset').removeAttr("disabled");
            }
            else
            {
                $('#asset').attr("disabled", "true");
		$('#asset').removeAttr("checked");
		
            }
	    
	    CreateTable();
        });
	
	$('input[name="tel"]').blur(function(){
	    
	    if($('input[name="tel"]').val() != "")
	    {
		var probleem = $('#melding');
		probleem.focus();
	    }
	})
	
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
            
            if($('.naam').val() == ""){
                $('#gebruiker').attr("disabled", "true");
		$('#gebruiker').removeAttr("checked");
	    }
            else
                $('#gebruiker').removeAttr("disabled");
		
	    CreateTable();
        });
        
        $('#gebruiker').click(function(){
	    CreateTable();
        });
	
	
        
        $('#asset').click(function(){
	    CreateTable();
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
        
        $('a[name="print"]').click(function(){
            window.open('toppiedesk.php?id=callprint&searchoid=' + $('input[name="oid"]').val(), 'Incidenten_van_gebruiker');
        });
        
        $('input[name="project"]').click(function(){
            $('input[name="afgemeld"]').attr('checked', true);
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
	    aanmeldermail();
	    
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
            var categorie = $('label[for="' + $('input[name="categorie"]:checked').attr('id') + '"]').html();
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
                "Melding: " + melding + "%0A" +
                "%0A" +
                "http://intranet/ict/toppiedesk2/toppiedesk.php?id=incidentnieuw%26searchoid=" + $('input[name="oid"]').val();
                
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
            var categorie = $('label[for="' + $('input[name="categorie"]:checked').attr('id') + '"]').html();
            var melding = $('textarea[name="probleem"]').val();
            
            if(aangemeld == null)
                aangemeld = "";
            
            var mailto = klant;
            var subject = "(Toppiedesk) " +  melding.substring(0,100).replace(/[^a-zA-Z 0-9]+/g,'');
            var body = "";
            
            body = 
                "Invoerder: " + invoerder + "%0A" +
                "Klant: " + klant + "%0A" + 
                "Telefoonnummer: " + telefoonnummer + "%0A" +
                "Aangemeld op: " + aangemeld + "%0A" +
                "categorie: " + categorie + "%0A" +
                "Melding: " + melding.replace(/[^a-zA-Z 0-9]+/g,'');
            
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
	
	function CreateTable()
	{
	    var gebruiker = "";
	    var asset = "";
	    
	    if($('#gebruiker').attr('checked'))
		gebruiker = $('input[name="naam"]').val().replace(/\s/g, "%20");
	    else gebruiker = "";
	    
	    if($('#asset').attr('checked'))
		asset = $('input[name="asset"]').val().replace(/\s/g,"%20");
	    else asset = "";
	    
	    $('#userHardware').load('./js/ajax/incidentTable.php?aanmelder=' + gebruiker + "&hardware=" + asset);
	}
    });
});