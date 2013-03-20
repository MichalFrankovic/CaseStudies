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
     echo '<form class="side-by-side" name="tentoForm" id="aktualnyformular" onsubmit="return validujFormProdukty()" method="POST" action="upravprodukt" accept-charset="UTF-8">';  
 }
   else  {         
    echo "<h2>    Pridaj produkt  </h2>";
    echo '<form class="side-by-side" name="tentoForm" id="aktualnyformular" onsubmit="return validujFormProdukty()" method="POST" action="pridajprodukt" accept-charset="UTF-8">';
         }

?>
    
      <!--  <label class="control-label">    ID OSOBY:          </label>    -->
        <input class="span4" type="hidden" name="id" value="<?php
                                                                if (isset($editovany_zaznam[0]->id))
                                                                    echo ($editovany_zaznam[0]->id); 
                                                             ?>">
    

    <div class="input-prepend">
        <label class="control-label">    Názov:          </label>
        <input class="span4" type="text" name="nazov" value="<?php
                                                                if (isset($editovany_zaznam[0]->t_nazov))
                                                                    echo ($editovany_zaznam[0]->t_nazov); 
                                                             ?>">
    </div>

    <div class="input-prepend">
        <label class="control-label">    Základná cena:  </label>
        <input class="span4" type="text" name="cena" value="<?php
                                                                if (isset($editovany_zaznam[0]->vl_zakladna_cena))
                                                                    echo ($editovany_zaznam[0]->vl_zakladna_cena); 
                                                            ?>">
    </div>

     <div class="input-prepend">
        <label class="control-label">    Merná jednotka:  </label>
        <select class="span4" type="text" name="jednotka"> 
            <?php
                    if (isset($editovany_zaznam[0]->t_merna_jednotka)) 
                    {
                        echo ('<option value="'.$editovany_zaznam[0]->t_merna_jednotka.'" selected="selected">'.$editovany_zaznam[0]->t_merna_jednotka.'</option>'); 
                        echo '
                                <option value="kus">kus</option>
                                <option value="kg">kg</option>
                                <option value="liter">liter</option>';
                    }
                        else {
                                echo '  <option value="kus">kus</option>
                                        <option value="kg">kg</option>
                                        <option value="liter">liter</option>';
                             }
             ?>
         </select>
    </div>

    <div class="input-prepend">
        <label class="control-label">    Kategória:      </label>
        <select name="kategoria-id" class="span4">
            <?php if (empty($editovany_zaznam[0]->id_kategoria_parent))    
                    echo '<option value="Nezaradený" selected="selected">Vyber</option>';  
            ?>

            @foreach ($kategorie as $kat)
            <option value="{{ $kat->id }}" @if ((isset($editovany_zaznam[0]->id_kategoria_parent)) AND ($kat->id == $editovany_zaznam[0]->id_kategoria_parent))
                                                selected="selected" @endif > {{ str_replace(" ", "&nbsp;",$kat->nazov); }}
                                           
            </option>
            @endforeach
           
        </select>
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
            <td>    @foreach ($kategorie as $kat) 
                        @if ($kat->id == $produkt->id_kategoria_parent)
                                {{$kat->nazov}}
                        @endif 
                    @endforeach                                  </td>
            <td> <a class="btn" href="sprava_produktov?id={{ $produkt->id }}"> Upraviť </a>
                 <a class="btn" href="zmazatprodukt?produkt={{ md5($produkt->id). $secretword}}" onclick="return confirm('Určite chcete zmazať tento záznam?')">
                    <i class="icon-remove"> </i>Vymazať</a>      </td>
        </tr>
        @endforeach
    </tbody>
  </table>
<a class="btn" href="#" onclick="multizmazanie('produkt[]')"> <i class="icon-remove"> </i> Vymazať zvolené </a>
</form>


@include('foot')