@include('head')

@if (isset($message) )
    <h3 style="color: #bc4348;">{{ $message }}</h3>
@endif


@include('spendings/sp-submenu')

<?php 
//Adriana Gogoľáková 25/03/2013
//Kód, ktorý mi zabezpečí, aby mi ostali vybrané kritériá zvolené

$fosoba = Input::get('osoba');
$fpartner = Input::get('prijemca');
$ftyp = Input::get('typ');

//Len pre overenie dosadzovanej hodnoty
/*echo "<pre>";
print_r($fosoba.", ".$fpartner.", ".$ftyp);
echo "</pre>";*/

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

     <div class="input-prepend">
        <span class="add-on">   Príjemca - obchodný partner:   </span>
            <select name="prijemca" class="span3">
                <option value="all" selected="selected">    -Výber-   </option>
                    @foreach ($partneri as $partner)
                    <option value="{{ $partner->id }}" <?php IF ($partner->id == $fpartner) { echo "selected"; }?>> {{ $partner->t_nazov }} </option>
                    @endforeach
            </select>
    </div>
 


     <div class="input-prepend">
            <span class="add-on"> Osoba - nákupca:   </span>
        <select name="osoba" class="span3">
            <option value="all" selected="selected">    -Výber-   </option>
            @foreach ($osoby as $osoba)
            <option value="{{ $osoba->id }}"    <?php IF ($osoba->id == $fosoba) { echo "selected"; }?>> {{$osoba->t_priezvisko_osoby }}</option>
            @endforeach
        </select>
    </div>

   
<div class="input-prepend">
            <span class="add-on"> Typ výdavku:   </span>
        <select name="typ" class="span3">
            <option value="all" selected="selected">    -Výber-   </option>
            @foreach ($typyV as $typV)
            <option value="{{ $typV->id }}"<?php IF ($typV->id == $ftyp) { echo "selected"; }?>> {{$typV->t_nazov_typu_vydavku }}</option>
            @endforeach
        </select>
    </div>


  <button type="reset" class="btn btn-primary">
            <i class="icon-remove icon-white"></i>
                Cancel
        </button>

        

<button type="submit" class="btn btn-primary">
                    <i class="icon-ok icon-white"></i>
                        Filtrovať
                 </button>

<a  onClick="history.go(-1)">    
                <button type="button" class="btn btn-primary">
                    <i class="icon-remove icon-white"></i>
                        Zruš filter
                 </button>
</a>

   

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

                     
            <td><a class="btn" href="simplespending?id={{ $vydavok->id }}">Upraviť</a>
                <a class="btn" href="deletespending?vydavok={{ md5($vydavok->id). $secretword}}"><i class="icon-remove"></i>Vymazať</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
    <a class="btn" href="#" onclick="multizmazanie('vydavok[]')"><i class="icon-remove"></i>Vymazať zvolené</a>
</form>



@include('foot')