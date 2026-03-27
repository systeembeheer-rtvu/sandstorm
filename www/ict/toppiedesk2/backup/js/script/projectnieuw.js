//zonder deze aanroep werken er sommige dingen niet
$(function(){   
    $('document').ready(function(){
        $("input[name='deadline']").datepicker({dateFormat: 'dd-mm-yy',yearRange:'-1:+2',changeMonth: true });
        $("input[name='date']").datepicker({dateFormat: 'dd-mm-yy',yearRange:'-1:+2',changeMonth: true });
    });
    
    $('input[name="o&a"]').click(function(){
        $('input[name="gesloten"]').attr('checked', true);
        return true;
    });
});
