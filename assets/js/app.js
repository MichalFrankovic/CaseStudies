/* javascript */

function formReset()
{
document.getElementById("aktualnyformular").reset();
}


$(function() {
    $( ".datepicker" ).datepicker();
});


function pridaj_riadok_do_vydavkov()
{
    //console.log(js_polozky[0].nazov);
    var tmptext
    for(i in js_polozky)
    {
        js_polozky[i].nazov = js_polozky[i].nazov.replace(/\s/g,'&nbsp;');

        tmptext +=  '<option value="'+js_polozky[i].id+'">'+js_polozky[i].nazov+'</option>';
    }
    $('#tbl-vydavky').append('<tr>\
        <td><input type="hidden" name="vydavok-id[]" id="hidden" value="N"/></td>\
    <td>\
        <select name="polozka-id[]" class="span4" style="font-family: Courier, \'Courier New\', monospace;" >\
    '+tmptext+'\
        </select>\
    </td>\
        <td>\
        <div class="input-append">\
            <input name="cena[]" class="span2" type="text"/>\
            <span class="add-on">€</span>\
        </div>\
    </td>\
    <td>\
        <div class="input-append">\
            <input name="mnozstvo[]" class="span1" type="text" value="1" />\
            <span class="add-on">m.j.</span>\
        </div>\
    </td>\
        <td>\
        <input name="zlava[]" class="span1" type="text" value="0" />\
    <select name="typ-zlavy[]" class="span2">\
    <option value="0" selected="selected">Bez z&lcaron;avy</option>\
    <option value="P" >Z&lcaron;ava v %</option>\
    <option value="A" >Z&lcaron;ava v EUR</option>\
</select>\
</td></tr>');
}


function multiCheck()
{
    var valChecked = $('#multicheck').val();
    if(valChecked == 0)
    {
        $('.spendcheck').prop('checked', true);
        $('#multicheck').val(1);
    }
    else
    {
        $('.spendcheck').prop('checked', false);
        $('#multicheck').val(0);
    }
}