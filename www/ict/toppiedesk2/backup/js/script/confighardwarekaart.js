//zonder deze aanroep werken er sommige dingen niet
$(function(){
    $('select[name="hardwaretype"]').change(function(){
        $('#dataform').submit();
    });
    
    $('a[name="save"]').click(function(){
        var temp = "";
        
        $('#dataform').parents()
            .find('.input').each(function(i){
                if(this.type == "checkbox")
                    temp += '"' + this.name + '":"' + this.checked + '",';
                else
                    temp += '"' + this.name + '":"' + this.value + '",';
            });
        
        $.getJSON("./js/ajax/hardwarekaart.php", {value:temp},function(data){
            
        });
        
        $('#js_opslaan').html($('#js_opslaan').html() + '<span style="color:#0000FF;"> - opgeslagen</span>');
        $('#js_show').show();
        return false;
    });
    
    $('a[name="archive"]').click(function(){
        alert("archive");
    });
    
    if($('input[name="searchoid"]').val() == "")
    {
        $('#js_show').hide();
    }
});