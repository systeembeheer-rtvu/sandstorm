//zonder deze aanroep werken er sommige dingen niet
$(function(){   
    $('document').ready(function(){
        $("input[name='datum']").datepicker({dateFormat: 'dd-mm-yy',yearRange:'-1:+2',changeMonth: true, onSelect: function(){
                $("form[name='js_submit']").submit();
            }
        });
        
        $("input[name='datum']").change(function(){
            $("form[name='js_submit']").submit();
        });
    });
});