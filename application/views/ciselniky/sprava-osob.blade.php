@include('head')

@if (isset($message) )
<h3 style="color: #bc4348;">{{ $message }}</h3>
@endif

@include('ciselniky/ciselniky-podmenu')

<?php

if (isset($editovany_zaznam))
 $editacia="ano";
    else $editacia = "nie";

?>


<div class="thumbnail" >

<?php
if ($editacia == 'ano') {
     echo "<h2>    Uprav osobu   </h2>";
     echo '<form class="side-by-side" name="tentoForm" id="aktualnyformular" onsubmit="return validujFormOsoby()" method="POST" action="upravitosobu" accept-charset="UTF-8">';  
 }
   else  {         
    echo "<h2>    Pridaj osobu  </h2>";
    echo '<form class="side-by-side" name="tentoForm" id="aktualnyformular" onsubmit="return validujFormOsoby()" method="POST" action="pridajosobu" accept-charset="UTF-8">';
         }

?>
    
        <input class="span3" type="hidden" name="id" value="<?php
                                                                if (isset($editovany_zaznam[0]->id))
                                                                    echo ($editovany_zaznam[0]->id); 
                                                             ?>">
    

    <div class="input-prepend">
        <label class="control-label">    Meno:          </label>
        <input class="span3" type="text" name="meno" value="<?php
                                                                if (isset($editovany_zaznam[0]->t_meno_osoby))
                                                                    echo ($editovany_zaznam[0]->t_meno_osoby); 
                                                             ?>">
    </div>


       
    <div class="input-prepend">
        <label class="control-label">    Priezvisko:          </label>
        <input class="span3" type="text" name="priezvisko" value="<?php
                                                                if (isset($editovany_zaznam[0]->t_priezvisko_osoby))
                                                                    echo ($editovany_zaznam[0]->t_priezvisko_osoby); 
                                                             ?>">

    </div>

<?php

if ($editacia == "nie") {

 echo
    '<div class="input-append">
        <label class="control-label">    Aktívna:    </label>   
        <input name="aktivna"  class="span2" type="checkbox" value="A" >     
    </div>';


}
?>

<?php 
$id = Input::get('id');
$znaky = DB::table('D_OSOBA')
->where_in('id', array($id))->get(array('id', 'fl_aktivna'));

?>
<div class="input-append">
        <?php

if ($editacia == "ano") {

 echo'
        <label class="control-label">    Aktívna:    </label>';}?>
        @foreach ($znaky as $znak)   
        <input name="aktivna"  class="span2" type="checkbox" value="{{ $znak-> fl_aktivna }}"
        <?php if ($znak->fl_aktivna =="A") { echo "checked"; } ?>/>
        @endforeach
    </div>



<?php

if ($editacia == "ano") {
     echo ' <a  onClick="history.go(-1)">    <!-- Tento Javascript vložený kvôli IE - ekvivalent takisto history.back() -->
                <button type="button" class="btn btn-primary">
                    <i class="icon-remove icon-white"></i>
                        Zruš
                 </button>
           </a>';

    echo '       <button type="submit" class="btn btn-primary">
                    <i class="icon-ok icon-white"></i>
                        Aktualizuj
                 </button>
         ';
    }
   else {
         echo ' <button type="reset" class="btn btn-primary">
                    <i class="icon-remove icon-white"></i>
                        Zruš
                </button>
              ';

         echo ' <button type="submit" class="btn btn-primary">
                    <i class="icon-ok icon-white"></i>
                        Pridaj
                </button>
              ';

        }

?>


{{ Form::close() }}
   
</div>

<h2>Zoznam osôb</h2>

<form id="form1" name="form1" method="post" action="multizmazanieosob">
  <table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th> <input type="checkbox" value="0" id="multicheck" onclick="multiCheck();" /> </th>
            <th>    Meno            </th>
            <th>    Priezvisko      </th>
            <th>    Aktívna         </th>
            <th>    Výber akcie     </th>
        </tr>
    </thead>

    <tbody>
        @foreach ($osoby as $osoba)
        <tr>
            <td><input type="checkbox" name="osoba[]" id="checkbox2" class="spendcheck" value="{{ md5($osoba->id). $secretword}}" /></td>
            <td>    {{ $osoba->t_meno_osoby }}          </td>
            <td>    {{ $osoba->t_priezvisko_osoby }}    </td>
            <td>    {{ $osoba->fl_aktivna }}            </td>
            <td> <a class="btn" href="sprava_osob?id={{ $osoba->id }}"> Upraviť </a>
                 <a class="btn" href="zmazatosobu?osoba={{ md5($osoba->id). $secretword}}" onclick="return confirm('Určite chcete zmazať tento záznam?')">
                    <i class="icon-remove"> </i>Vymazať</a>      </td>
        </tr>
        @endforeach
    </tbody>
  </table>
<a class="btn" href="#" onclick="multizmazanie('osoba[]')"> <i class="icon-remove"> </i> Vymazať zvolené </a>
</form>


@include('foot')