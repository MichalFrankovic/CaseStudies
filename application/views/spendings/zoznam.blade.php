@include('head')

@if(Session::get('message'))
        <div class="information {{ Session::get('status_class') }}">
            {{ Session::get('message') }}
        </div>
@endif

@include('spendings/sp-submenu')

<?php /*KVOLI ZADÁVANIU DÁTUMOV CEZ JAVASCRIPT ZA VYUŽITIA CSS ŠTÝLU */ ?>
{{ HTML::script('assets/js/bootstrap-editable.js') }}
{{ HTML::style('assets/css/bootstrap-editable.css') }}


<?php 
//Adriana Gogoľáková 25/03/2013
//Kód, ktorý mi zabezpečí, aby mi ostali vybrané kritériá zvolené

$fosoba = Input::get('osoba');
$fpartner = Input::get('partner');
$ftyp = Input::get('typ');

//Len pre overenie dosadzovanej hodnoty
/*echo "<pre>";
print_r($fosoba.", ".$fpartner.", ".$ftyp);
echo "</pre>";*/

    $zdroj2 = Input::get('partner');
    $osoba2 = Input::get('osoba');
    $styp2 = Input::get('typ');
    
?>


{{ Form::open('spendings/filter', 'POST', array('class' => 'side-by-side')); }}
<div class="thumbnail" >
<h2>    Filter výdavkov </h2>
    <h4>    Dátum   </h4>
    <div class="input-prepend" style="float:left;width:275px">
        <span class="add-on">   Od:         </span>
        <input class="span3 datepicker" type="text" name="od" value="{{ $od }}">
    </div>

    <div class="input-prepend">
        <span class="add-on">   Do:         </span>
        <input class="span3 datepicker" type="text" name="do" value="{{ $do }}">
    </div>

 <!--Adriana Gogoľáková: Obchodný partner funkčný aj pri filtrovaní--> 
  <div class="input-prepend">
        <span class="add-on" style="width:190px;text-align:left;padding-left:10px"> Obchodný partner - príjemca: </span>
    <select name="partner"  class="span3">
        <option value="all" selected="selected">  -- VŠETCI --  </option>
        @foreach ($obch_partneri as $source)
        <option value="{{ $source->id }}" <?php if($source->id==$zdroj2){echo 'selected="selected"';}?>> {{ $source->t_nazov }}</option>
        @endforeach
    </select>
</div>

<!--Adriana Gogoľáková: Osoba funkčná aj pri filtrovaní-->
    <div class="input-prepend">
        <span class="add-on" style="width:190px;text-align:left;padding-left:10px"> Osoba - nákupca: </span>
    <select name="osoba"  class="span3">
        <option value="all" selected="selected"> -- VŠETKY -- </option>
        @foreach ($osoby as $osoba)
        <option value="{{ $osoba->id }}" <?php if($osoba->id==$osoba2){echo 'selected="selected"';}?>> {{ $osoba->t_meno_osoby }}&nbsp;{{ $osoba->t_priezvisko_osoby }}</option>
        @endforeach
    </select>
 </div>

<!--Adriana Gogoľáková: Typ výdavku funkčný aj pri filtrovaní-->  
<div class="input-prepend">
            <span class="add-on" style="width:190px;text-align:left;padding-left:10px"> Typ výdavku:   </span>
        <select name="typ" class="span3">
            <option value="all" selected="selected">  -- VŠETKY --   </option>
            @foreach ($typyV as $typV)
            <option value="{{ $typV->id }}"<?php IF ($typV->id == $styp2) { echo "selected"; }?>> {{$typV->t_nazov_typu_vydavku }}</option>
            @endforeach
        </select>
    </div>



<!--Adriana Gogoľáková: Tlačidlá pre filtrovanie a zruzenie filtru-->

    <a class="btn btn-primary" href="{{ URL::to('spendings/zoznam') }}" ><i class="icon-remove icon-white"> </i> Vynulovať filter </a>
       
    <button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"> </i> Zobraziť  </button>
  

{{ Form::close() }}
</div>



<h2 class="">   Zoznam výdavkov </h2>
<form id="form1" name="form1" method="post" action="multideletespending">
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>    <input type="checkbox" value="0" id="multicheck" onclick="multiCheck();" /> </th>
            <th>    Dátum               </th>
            <th>    Príjemca platby     </th>
            <th>    Nákupca - osoba     </th>
            <th>    Typ výdavku         </th>
            <th>    Poznámka            </th>
            <th>    Suma v €            </th>
            <th>    Výber akcie         </th>
        </tr>
        </thead>
 


        <tbody>
        @foreach ($vydavky as $vydavok)
        <tr>
            <td> <input type="checkbox" name="vydavok[]" id="checkbox2" class="spendcheck" value="{{ md5($vydavok->id). $secretword}}" /></td>
            <td>    {{ date('d.m.Y',strtotime($vydavok->d_datum)) }}        </td>
            <td>    {{ $vydavok->partner->t_nazov }}                        </td>
            <td>     @foreach ($osoby as $osoba)
                     @if ($osoba->id == $vydavok->id_osoba) 
                            {{$osoba->t_priezvisko_osoby }}
                    @endif
                    @endforeach                                             </td>
           <td>     @foreach ($typyV as $typV)
                     @if ($typV->id == $vydavok->id_typ_vydavku) 
                            {{$typV->t_nazov_typu_vydavku }}
                    @endif
                    @endforeach                                             </td>
            <td>    {{ $vydavok->t_poznamka }}                              </td>
            <td>    {{ round($vydavok->suma_vydavku_po_celk_zlave,2) }} EUR </td>

                     
            <td><a class="btn btn-primary" href="simplespending?id={{ $vydavok->id }}">Upraviť</a>
                <a class="btn btn-danger" href="deletespending?vydavok={{ md5($vydavok->id). $secretword}} " onclick="return confirm('Určite chcete zmazať tento záznam?')"><i class="icon-remove icon-white"></i>Vymazať</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
    <a class="btn btn-danger" href="#" onclick="multizmazanie('vydavok[]')"><i class="icon-remove icon-white"></i>Vymazať zvolené</a>
</form>



@include('foot')