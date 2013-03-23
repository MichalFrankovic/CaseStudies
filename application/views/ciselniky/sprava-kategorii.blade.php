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
     echo "<h2>    Uprav kategóriu   </h2>";
     echo '<form class="side-by-side" name="tentoForm" id="aktualnyformular" onsubmit="return validujFormKategorie()" method="POST" action="upravkat" accept-charset="UTF-8">';  
 }
   else  {         
    echo "<h2>    Pridaj kategóriu  </h2>";
    echo '<form class="side-by-side" name="tentoForm" id="aktualnyformular" onsubmit="return validujFormKategorie()" method="POST" action="pridajkategoriu" accept-charset="UTF-8">';
         }

?>


        <input class="span4" type="hidden" name="id" value="<?php
                                                                if (isset($editovany_zaznam[0]->id))
                                                                    echo ($editovany_zaznam[0]->id); 
                                                             ?>">
    

    <div class="input-prepend">
        <label class="control-label">    Kategória:          </label>
        <input class="span4" type="text" name="nazov" value="<?php
                                                                if (isset($editovany_zaznam[0]->t_nazov))
                                                                    echo ($editovany_zaznam[0]->t_nazov); 
                                                             ?>">
    </div>

    <div class="input-prepend">
      <label class="control-label">  Nadkategória:          </label>

        <select name="Nadkategoria-id" class="span4">
           <option value="" selected="selected">  </option>
            @foreach ($kategorie as $kat)
            <option value="{{ $kat->id }}" @if ((isset($editovany_zaznam[0]->id_kategoria_parent)) AND ($kat->id == $editovany_zaznam[0]->id_kategoria_parent))
                                                selected="selected" @endif > {{ str_replace(" ", "&nbsp;",$kat->nazov); }}
            </option>
            @endforeach
        </select>
    </div>

{{ Form::open('ciselniky/pridajkategoriu', 'POST', array('class' => 'side-by-side','id' => 'aktualnyformular')); }}

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
   else {echo ' <button type="reset" class="btn btn-primary">
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



<h2 class="">   Zoznam kategórií    </h2>
<form id="form1" name="form1" method="post" action="multizmazaniekat">
  <table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th> <input type="checkbox" value="0" id="multicheck" onclick="multiCheck();" /> </th>
            <th>    Kategória      </th>
            <th>    Nadkategória   </th>
            <th>    Výber akcie          </th>
        </tr>
    </thead>

    <tbody>
        @foreach ($kategorie2 as $kat)
        <tr>
            <td><input type="checkbox" name="kat[]" id="checkbox2" class="spendcheck" value="{{ md5($kat->id). $secretword}}" /></td>
            <td>    {{ $kat->t_nazov }}              </td> 
            <td>    {{ $kat->id_kategoria_parent }}              </td>
            <td> <a class="btn" href="sprava_kategorii?id={{ $kat->id }}"> Upraviť </a>
                 <a class="btn" href="zmazatkategoriu?kat={{ md5($kat->id). $secretword}}" onclick="return confirm('Určite chcete zmazať tento záznam?')">
                    <i class="icon-remove"> </i>Vymazať</a>      </td>
        </tr>
        @endforeach
    </tbody>
  </table>
<a class="btn" href="#" onclick="multizmazanie('kat[]')"> <i class="icon-remove"> </i> Vymazať zvolené </a>
</form>



@include('foot')