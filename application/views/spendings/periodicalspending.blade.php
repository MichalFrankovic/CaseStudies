@include('head')

@if(Session::get('message'))
        <div class="information {{ Session::get('status_class') }}">
            {{ Session::get('message') }}
        </div>
@endif

<script>    

function daco() {

    $('select#abc').each(function()
        {
        var x = $('option:selected',$(this)).attr('value');
        //alert('ID vybranej šablóny je: ' +x);

        $.get('vyber_cenu_pre_sablonu?id='+x,
            function(data) {
                $('input#cena').val(data);
                //alert('Cena vybraná z databázy pre túto šablónu je: ' +data);
                });
        
        // Osoba, ktorá je uvedená v šablóne:  --- JSON FORMÁT už z PHP funkcie---
        $.get('vyber_osobu_pre_sablonu?id='+x,
            function(osoba) {

               $('select#zaplatil').append("<option value='"+osoba.id+"' selected='selected'>"+ osoba.priezvisko + " "+ osoba.meno +" </option>");
                }, "json");
    });  

}



</script> 

@include('spendings/sp-submenu')

<?php /*KVOLI ZADÁVANIU DÁTUMOV CEZ JAVASCRIPT ZA VYUŽITIA CSS ŠTÝLU */ ?>
{{ HTML::style('assets/css/bootstrap-editable.css') }}
{{ HTML::script('assets/js/bootstrap-editable.js') }}

@if (isset($error) && $error == true)
    <div class="alert alert-error">{{ $error }}</div>
@endif

<div class="thumbnail">
    <h4> Parametre: </h4>
{{ Form::open('spendings/savefromtemplate', 'POST', array('class' => '')); }}
    <table border="0" style="width: 100%;">
          <tr>
            <td>
                <div class="input-prepend">
                    <span class="add-on">   Dátum:          </span>
                    <input class="span2 datepicker" type="text" name="datum" value="<?php $x=$datum; $x = date('d.m.Y'); echo $x;?>" />
                </div>
            </td>

            <td>
                <div {{ (is_array($errors) && isset($errors['nazov'])) ? ' class="control-group error input-prepend" style="float:left"' : 'class="input-prepend" style="float:left"' }}>
                
                     <span class="add-on">  Názov šablóny:  </span>
                        <select id="abc" onchange="daco()" name="sablona" class="span2">
                            <option value="nic">    Vyber šablónu   </option>
                        @foreach ($sablony as $sablona)
                            <option value="{{ $sablona->id }}"> {{ $sablona->t_poznamka }}  </option>
                        @endforeach
                        </select>
                </div>
            </td>

            <td>
                <div class="input-prepend">
                    <span class="add-on">   Zaplatil:   </span>
                        <select id="zaplatil" name="osoba" class="span2">
                        @foreach ($osoby as $osoba)
                            <option value="{{ $osoba->id }}"> {{$osoba->t_priezvisko_osoby }} {{ $osoba->t_meno_osoby }} </option>
                        @endforeach
                        </select>
                </div>
            </td>

            <td>
                 <div class="input-prepend">
                    <label class="add-on">   Suma v €:   </label>
                            <input id="cena" class="span2" type="text" name="suma">
                </div>
            </td>
        </tr>

    </table>

    <button type="submit" class="btn btn-primary">
        <i class="icon-edit icon-white"></i>
            Uložiť ako výdavok
    </button>
        
</div>
{{ Form::close() }}

<HR>

<h4> Zoznam šablón výdavkov: </h4>
<form id="form1" name="form1" method="post" action="zmazsablony">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th> <input type="checkbox" value="0" id="multicheck" onclick="multiCheck();" />    </th>
                <th>    Názov           </th>
                <th>    Príjemca platby </th>
                <th>    Zaplatil        </th>
                <th>    Typ výdavku     </th>
                <th>    Pravidelnosť    </th>
                <th>    Kategória       </th>
                <th>    Suma v €        </th>
                <th>    Výber akcie     </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sablony as $sablona)
            <tr>
                <td style="text-align: center;"> <input type="checkbox" name="sablona[]" id="checkbox2" class="spendcheck" value="{{ md5($sablona->id). $secretword}}" /></td>
                <td class="skrat_ak_dlhy">    {{ $sablona->t_poznamka }}                        </td>
                <td>    {{ $sablona->prijemca }}                                                </td>
                <td>    {{ $sablona->t_priezvisko_osoby }} {{ $sablona->t_meno_osoby }}         </td>
                <td>    {{ $sablona->t_nazov_typu_vydavku }}                                    </td>
                <td>    {{ (($sablona->fl_pravidelny == 'A')? "Pravidelný" : "Nepravidelný") }} </td>
                <td>    {{ $sablona->kategoria }}                                               </td>
                <td>    {{ $sablona->vl_jednotkova_cena }} €                                    </td>
                <td style="text-align: center;">
                    <a class="btn btn-primary" href="sablona?id={{ $sablona->id }}"> Upraviť </a>
                    <a class="btn btn-danger" href="zmazsablonu?sablona={{ md5($sablona->id). $secretword}}" onclick="return confirm('Určite chcete zmazať tento záznam?')">
                        <i class="icon-remove icon-white"> </i> Vymazať </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a class="btn btn-danger" href="#" onclick="multizmazanie('sablona[]')"><i class="icon-remove icon-white"></i>Vymazať zvolené</a>
</form>


@include('foot')