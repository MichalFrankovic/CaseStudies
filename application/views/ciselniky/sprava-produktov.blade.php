@include('head')

@if (isset($message) )
<h3 style="color: #bc4348;">    {{ $message }}  </h3>
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
     echo "<h2>    Uprav produkt   </h2>";
     echo '<form class="side-by-side" id="aktualnyformular" method="POST" action="upravprodukt" accept-charset="UTF-8">';  
 }
   else  {         
    echo "<h2>    Pridaj produkt  </h2>";
    echo '<form class="side-by-side" id="aktualnyformular" method="POST" action="pridajprodukt" accept-charset="UTF-8">';
         }

?>
    
      <!--  <label class="control-label">    ID OSOBY:          </label>    -->
        <input class="span3" type="hidden" name="id" value="<?php
                                                                if (isset($editovany_zaznam[0]->id))
                                                                    echo ($editovany_zaznam[0]->id); 
                                                             ?>">
    

    <div class="input-prepend">
        <label class="control-label">    Názov:          </label>
        <input class="span3" type="text" name="nazov" value="<?php
                                                                if (isset($editovany_zaznam[0]->t_nazov))
                                                                    echo ($editovany_zaznam[0]->t_nazov); 
                                                             ?>">
    </div>

    <div class="input-prepend">
        <label class="control-label">    Základná cena:  </label>
        <input class="span3" type="text" name="cena" value="<?php
                                                                if (isset($editovany_zaznam[0]->vl_zakladna_cena))
                                                                    echo ($editovany_zaznam[0]->vl_zakladna_cena); 
                                                            ?>">
    </div>

     <div class="input-prepend">
        <label class="control-label">    Merná jednotka:  </label>
        <input class="span3" type="text" name="jednotka" value="<?php
                                                                if (isset($editovany_zaznam[0]->t_merna_jednotka))
                                                                    echo ($editovany_zaznam[0]->t_merna_jednotka); 
                                                            ?>">
    </div>

    <div class="input-prepend">
        <label class="control-label">    Kategória:      </label>
        <select name="category-id" class="span3">
            @foreach ($kategorie as $kat)
            <option value="{{ $kat->id }}">{{ $kat->t_nazov }}</option>
            @endforeach
        </select>
    </div>
   

<?php

if ($editacia == "ano") {
    echo ' <a  href="sprava_produktov">
                <button type="button" class="btn btn-primary">
                    <i class="icon-remove icon-white"></i>
                        Cancel
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
                        Cancel
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



<h2 class="">   Zoznam produktov    </h2>
<form id="form1" name="form1" method="post" action="multizmazanie">
  <table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th> <input type="checkbox" value="0" id="multicheck" onclick="multiCheck();" /> </th>
            <th>    Názov           </th>
            <th>    Merná jednotka  </th>
            <th>    Základná cena   </th>
            <th>    Kategória       </th>
            <th>    Výber akcie     </th>
        </tr>
    </thead>

    <tbody>
        @foreach ($produkty as $produkt)
        <tr>
            <td><input type="checkbox" name="produkt[]" id="checkbox2" class="spendcheck" value="{{ md5($produkt->id). $secretword}}" /></td>
            <td>    {{ $produkt->t_nazov }}                      </td>
            <td>    {{ $produkt->t_merna_jednotka }}             </td>
            <td>    {{ $produkt->vl_zakladna_cena }}             </td>
            <td>    {{ $produkt->id_kategoria_parent }}          </td>
            <td> <a class="btn" href="sprava_produktov?id={{ $produkt->id }}"> Upraviť </a>
                 <a class="btn" href="zmazatprodukt?produkt={{ md5($produkt->id). $secretword}}" onclick="return confirm('Určite chcete zmazať tento záznam?')">
                    <i class="icon-remove"> </i>Vymazať</a>      </td>
        </tr>
        @endforeach
    </tbody>
  </table>
<a class="btn" href="#" onclick="document.getElementById('form1').submit(); return false;"> <i class="icon-remove"> </i> Vymazať zvolené </a>
</form>


@include('foot')