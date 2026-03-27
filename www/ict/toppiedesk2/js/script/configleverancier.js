//zonder deze aanroep werken er sommige dingen niet
$(function(){
    $('document').ready(function(){
        $('input[name="opslaan"]').click(function(){
            var id = $('input[name="oid"]').val();
            var leverancier = $('input[name="leverancier"]').val();
            var klantnummer = $('input[name="klantnummer"]').val();
            var contactpersoon = $('input[name="contactpersoon"]').val();
            var telefoonnummer = $('input[name="telefoonnummer"]').val();
            
            $.getJSON('./js/ajax/leverancierOpslaan.php',{"id":id,"leverancier":leverancier,"klantnummer":klantnummer,"contactpersoon":contactpersoon,"telefoonnummer":telefoonnummer});
        });
        
        $('a[name="archive"]').click(function(){
            var id = $('input[name="oid"]').val();
            
            $.getJSON('./js/ajax/leverancierAchiveren.php', {"id":id});
            
            return false;
        });
    });
});