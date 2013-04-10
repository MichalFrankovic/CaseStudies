
// Funkcie pre validácie
function validujFormOsoby()
{
    var priezvisko = document.forms["tentoForm"]["priezvisko"];
       
     if (notEmpty(priezvisko, "Prosím zadajte priezvisko")) {

        if(ismeno(priezvisko)){ 
                        
            return true;
             }
         }
        
return false;
}


function validujFormPartneri()
{
    var nazov = document.forms["tentoForm"]["nazov"];
    var typ = document.forms["tentoForm"]["typ"];
    
     if(notEmpty(nazov, "Prosím zadajte názov")){                
          
        if(madeSelection(typ, "Zadajte prosím typ")){  

            return true;
             }
        }

return false;
}


function validujFormKategorie()
{
    var nazov = document.forms["tentoForm"]["nazov"];
    var nadkategoria = document.forms["tentoForm"]["Nadkategoria-id"];
    
     if(notEmpty(nazov, "Prosím zadajte názov")){    

        if(madeSelection(nadkategoria, "Zadajte prosím nadkategóriu")){              
                   
            return true; 
            }
        }

return false;
}


function validujFormProdukty()
{
    var nazov = document.forms["tentoForm"]["nazov"];
    var cena = document.forms["tentoForm"]["cena"];
    var kategoria = document.forms["tentoForm"]["kategoria-id"];
    
    
     if(notEmpty(nazov, "Prosím zadajte názov")){                
          
        if(isNumeric(cena, "Zadajte prosím číslo")){  

            if(madeSelection(kategoria, "Zadajte prosím kategóriu")){  
                return true;
                 }
            }
        }

return false;
}


function validujFormTypyPrijmu()
{
    var nazov_typu = document.forms["tentoForm"]["nazov_typu"];
     
     if(notEmpty(nazov_typu, "Prosím zadajte názov")){                
                   
            return true;  
        }

return false;
}





// Funkcia na validáciu, či užívateľ niečo zadal (môžu to byť aj čísla)
        function notEmpty(elem, helperMsg)
        {
            if(elem.value.trim() == '')
            {
                alert(helperMsg);
                elem.focus(); // set the focus to this input
                return false;
            }

            /*var alphaExp = /^[a-zA-ZáéíóúýžščďťňľÁÉÍÓÚÝŽŠČĎŤŇĽäô]+$/;
                if(elem.value.match(alphaExp))
                {
 
                } else {
                        alert('Nepovolený znak!');
                        elem.focus(); // set the focus to this input
                        elem.select();
                        return false;
                    }*/

            return true;
        }


// Funkcia na validáciu, či užívateľ zadal znaky BEZ číslic
        function ismeno(input)
        {  
                // Check if input contains a digit
                if (/\d/.test(input.value)) {
                    alert('Priezvisko nemôže obsahovať číslo');

                    // Remove all digit characters
                    input.value = input.value.replace(/\d/gi, '');
                    return false;
                }

                // Check if input is empty
                if (input.value === '') {
                    alert('Nezadal si priezvisko');
                    return false;
                    }

            return true;
        }


// Funkcia na validáciu, či užívateľ zadal číslice
        function isNumeric(elem, helperMsg)
        {
            var numericExpression = /^[0-9]+$/;
            if(elem.value.match(numericExpression))
            {
                return true;
            } else {
                    alert('Toto nie je číslo');
                    elem.focus();
                    elem.select();
                    return false;
            }
        }


// Funkcia, či užívateľ vybral možnosť option zo select-u
        function madeSelection(elem, helperMsg)
        {
            if(elem.value == "Nezaradený")
            {
                alert(helperMsg);
                elem.focus();
                return false;
            } else {
                return true;
            }
        }



// -----------------------------------------------------------------------------------

        function multizmazanie(input)
        {
           
            var chks = document.getElementsByName(input);
            var hasChecked = false;

                for (var i = 0; i < chks.length; i++)
                    {
                        if (chks[i].checked)
                            {
                                hasChecked = true;
                                break;
                            }

                    }

                if (hasChecked == false)
                    {
                    alert("Nevybral si žiadnu z položiek! \nSa spamätaj akože...");
                    return false;
                    }

            var odpoved = confirm('Určite chcete zmazať tieto záznamy?');
    
                if (odpoved) {
                    document.getElementById('form1').submit();
                    }
                    
        return true;
        }


// -----------------------------------------------------------------------------------

function formReset()
{
document.getElementById("aktualnyformular").reset();
}


// -----------------------------------------------------------------------------------

$(function() {
    $( ".datepicker" ).datepicker();
});

// -----------------------------------------------------------------------------------


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


// -----------------------------------------------------------------------------------


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