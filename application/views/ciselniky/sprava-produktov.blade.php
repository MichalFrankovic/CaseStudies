@include('head')

@if(Session::get('message'))
        <div class="information {{ Session::get('status_class') }}">
            {{ Session::get('message') }}
        </div>
@endif


@include('ciselniky/ciselniky-podmenu')

<script type="text/javascript">
// Zabránenie duplicitným zobrazeniam hodnôt v selectoch na stránkach
    window.onload = function()
    {
        var found = [];
            $("select option").each(function() 
                {
                  if($.inArray(this.value, found) != -1) $(this).remove();
                  found.push(this.value);
                });
    }

</script>

<?php

if (isset($editovany_zaznam))
 $editacia="ano";
    else $editacia = "nie";

?>

@if (isset($error) && $error == true)
    <div class="alert alert-error">{{ $error }}</div>
@endif

<div class="thumbnail">

<?php
if ($editacia == 'ano') {
     echo "<h3>  Uprav produkt:  </h3>";
     echo '<form class="side-by-side" name="tentoForm" id="aktualnyformular"  method="POST" action="upravprodukt" accept-charset="UTF-8">';  
 }
   else  {         
    echo "<h3>   Pridaj produkt: </h3>";
    echo '<form class="side-by-side" name="tentoForm" id="aktualnyformular"  method="POST" action="pridajprodukt" accept-charset="UTF-8">';
         }

?>
    
    <!--  <label class="control-label">    ID OSOBY:          </label>    -->
    <input class="span4" type="hidden" name="id" value="<?php
                                                            if (isset($editovany_zaznam[0]->id))
                                                                echo ($editovany_zaznam[0]->id); 
                                                         ?>">
    

   <div {{ isset($errors->nazov) || (is_array($errors) && isset($errors['nazov'])) ? ' class="control-group error"' : '' }}>
        <label class="control-label">    Názov:          </label>
        <input class="span4" type="text" name="nazov" value="<?php
                                                    if (isset($meneny_nazov))
                                                                echo $meneny_nazov;

                                                            elseif (isset($editovany_zaznam[0]->t_nazov))
                                                                    echo ($editovany_zaznam[0]->t_nazov); 
                                                             ?>">
    {{ isset($errors->nazov) || (is_array($errors) && isset($errors['nazov'])) ? '<span class="help-inline">'.$errors['nazov'].'</span>' : '' }}
    </div>


    <div {{ isset($errors->cena) || (is_array($errors) && isset($errors['cena'])) ? ' class="control-group error"' : '' }}>
        <label class="control-label">    Základná cena:  </label>
        <input class="span4" type="text" name="cena" value="<?php
                                                    if (isset($meneny_cena))
                                                                echo $meneny_cena;

                                                            elseif (isset($editovany_zaznam[0]->vl_zakladna_cena))
                                                                    echo ($editovany_zaznam[0]->vl_zakladna_cena); 
                                                            ?>">
    {{ isset($errors->cena) || (is_array($errors) && isset($errors['cena'])) ? '<span class="help-inline">'.$errors['cena'].'</span>' : '' }}
    </div>


     <div class="input-prepend">
        <label class="control-label">    Merná jednotka:  </label>
        <select class="span4" type="text" name="jednotka"> 
            <?php

                if (isset($meneny_jednotka))
                {
                    echo '<option value="'.$meneny_jednotka.'" selected="selected">'.$meneny_jednotka.'</option>'; 
                    echo '
                                <option value="kus">    kus     </option>
                                <option value="kg">     kg      </option>
                                <option value="liter">  liter   </option>';
                }

                elseif (isset($editovany_zaznam[0]->t_merna_jednotka)) 
                    {
                        echo ('<option value="'.$editovany_zaznam[0]->t_merna_jednotka.'" selected="selected">'.$editovany_zaznam[0]->t_merna_jednotka.'</option>'); 
                        echo '
                                <option value="kus">    kus     </option>
                                <option value="kg">     kg      </option>
                                <option value="liter">  liter   </option>';
                    }
                        else {
                                echo '  <option value="kus">    kus     </option>
                                        <option value="kg">     kg      </option>
                                        <option value="liter">  liter   </option>';
                             }
             ?>
         </select>
    </div>


    <div {{ isset($errors->kategoria) || (is_array($errors) && isset($errors['kategoria'])) ? ' class="control-group error"' : '' }}>
        <label class="control-label">    Kategória:      </label>
        <select name="kategoria-id" class="span4">
            <?php if (empty($editovany_zaznam[0]->id_kategoria_parent))    
                    echo '<option value="Nezaradený" selected="selected">Vyber</option>';  
            ?>

            @foreach ($kategorie as $kat)
            <option value="{{ $kat->id }}" 
             @if ((isset($meneny_kategoria)) AND ($kat->id == $meneny_kategoria))
	                                                selected="selected" @endif 
            @if ((isset($editovany_zaznam[0]->id_kategoria_parent)) AND ($kat->id == $editovany_zaznam[0]->id_kategoria_parent))
                                                selected="selected" @endif > {{ str_replace(" ", "&nbsp;",$kat->nazov); }}
                                           
            </option>
            @endforeach
           
            <?php /*
            @if (isset($meneny_kategoria)
                @foreach ($kategorie as $kat)
            <option value="{{ $kat->id }}" @if ($kat->id == $meneny_kategoria)
                                                selected="selected" @endif > {{ str_replace(" ", "&nbsp;",$kat->nazov); }}
                                           
            </option>
                @endforeach


            @endif */ ?>
           
        </select>
    {{ isset($errors->kategoria) || (is_array($errors) && isset($errors['kategoria'])) ? '<span class="help-inline">'.$errors['kategoria'].'</span>' : '' }}
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



<h3>   Zoznam produktov:    </h3>
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

    <tbody>     <?php /* To ->results je pridané len kvôli stránkovaniu */ ?>
        @foreach ($produkty->results as $produkt)
        <tr>
            <td style="text-align: center;"> <input type="checkbox" name="produkt[]" id="checkbox2" class="spendcheck" value="{{ md5($produkt->id). $secretword}}" /> </td>
            <td>    {{ $produkt->t_nazov }}                      </td>
            <td>    {{ $produkt->t_merna_jednotka }}             </td>
            <td>    {{ $produkt->vl_zakladna_cena }}             </td>
            <td>    @foreach ($kategorie as $kat) 
                        @if ($kat->id == $produkt->id_kategoria_parent)
                                {{$kat->nazov}}
                        @endif 
                    @endforeach                                  </td>
            <td style="text-align: center;"> 
                <a class="btn btn-primary" href="sprava_produktov?id={{ $produkt->id }}"> Upraviť </a>
                <a class="btn btn-danger" href="zmazatprodukt?produkt={{ md5($produkt->id). $secretword}}" onclick="return confirm('Určite chcete zmazať tento záznam?')">
                    <i class="icon-remove icon-white"> </i>Vymazať</a>     
            </td>
        </tr>
        @endforeach
    </tbody>
  </table>
   <?php /* Navigačná lista pre stránkovanie */ echo $produkty->links(); ?>
<a class="btn btn-danger" href="#" onclick="multizmazanie('produkt[]')"> <i class="icon-remove icon-white"> </i> Vymazať zvolené </a>
</form>


@include('foot')