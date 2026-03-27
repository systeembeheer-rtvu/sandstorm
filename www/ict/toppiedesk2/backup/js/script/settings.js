//zonder deze aanroep werken er sommige dingen niet
$(function(){
    $("#accordion").accordion({ header: 'h3', autoHeight: false });
    $(".tabs").tabs();
    
    $('form').submit(function(){
        var part = $(this.part).val();
        var action = $(this.submit).val();
        
        if(part == "behandelaar" && action == "Aanmaken")
        {
            var naam = $(this.naam).val();
            
            $.get("./js/ajax/settings.php",{
                "part":part,
                "action":action,
                "naam":naam
            });
            
            $(this.naam).val("");
        }
        else if(part == "behandelaar" && action == "(de)activeren")
        {
            var id = $(this.behandelaar).val();
            
            $.get("./js/ajax/settings.php",{
                "part":part,
                "action":action,
                "id":id
            });
        }
        else if(part == "status" && action == "Aanmaken")
        {
            var naam = $(this.naam).val();
            
            $.get("./js/ajax/settings.php",{
                "part":part,
                "action":action,
                "naam":naam
            });
            
            $(this.naam).val("");
        }
        else if(part == "status" && action == "(de)activeren")
        {
            var status = $(this.status).val();
            
            $.get("./js/ajax/settings.php",{
                "part":part,
                "action":action,
                "status":status
            });
        }
        else if(part == "categorie" && action == "Aanmaken")
        {
            var catName = $(this.catName).val();
            
            $.get("./js/ajax/settings.php",{
                "part":part,
                "action":action,
                "catName":catName
            });
            
            $(this.catName).val("");
        }
        else if(part == "categorie" && action == "(de)activeren")
        {
           var categorie = $(this.categorie).val();
            
            $.get("./js/ajax/settings.php",{
                "part":part,
                "action":action,
                "categorie":categorie
            }); 
        }
        else if(part == "userAccount" && action == "Aanpassen")
        {
            var naam = $(this.naam).val();
            var afdelingArray = new Array();
            
            $.each($('input[name="afdeling"]'), function(index, value){
                if(value.checked == true)
                    afdelingArray.push(value.value);
            });
            
            $.get("./js/ajax/settings.php", {
                "part":part,
                "action":action,
                "loginName":naam,
                "afdelingen":afdelingArray.toLocaleString()
            });
        }
        
        $(this).ajaxComplete(function(){
            location.reload();
        });
        
        return false;
    }) 
});