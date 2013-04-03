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
if ($editacia == 'ano')
  {
   
     echo "<h2>    Upraviť partnera   </h2>";
     echo '<form class="side-by-side" name="tentoForm" id="aktualnyformular" onsubmit="return validujFormPartneri()" method="POST" action="upravitpartnera" accept-charset="UTF-8">';  
  }
else
  {         
     echo "<h2>    Pridať partnera    </h2>";
     echo '<form class="side-by-side" name="tentoForm" id="aktualnyformular" onsubmit="return validujFormPartneri()" method="POST" action="pridatpartnera" accept-charset="UTF-8">';
    }
?>
    
    <input class="span4" type="hidden" name="id" value="<?php if (isset($editovany_zaznam[0]->id))
                                                                    echo ($editovany_zaznam[0]->id); 
                                                         ?>">
    
    <div class="input-prepend">
        <label class="control-label">    Názov:          </label>
        <input class="span4" type="text" name="nazov" value="<?php if (isset($editovany_zaznam[0]->t_nazov))
                                                                    echo ($editovany_zaznam[0]->t_nazov); 
                                                              ?>">
    </div>

  <div class="input-prepend">
      <label class="control-label">    Typ partnera:          </label>
        <select class="span4" type="text" name="typ">
           <?php
              if (isset($editovany_zaznam[0]->fl_typ)) 
                {
                  echo ('<option value="'.$editovany_zaznam[0]->fl_typ.'" selected="selected">'.$editovany_zaznam[0]->fl_typ.'</option>'); 
                }  
             ?>
    			<option value="Nezaradený">  Vyberte                         </option>
    			<option value="Príjemca platby">                 Príjemca platby                 </option>
    			<option value="Zdroj príjmu">                    Zdroj príjmu                    </option>
    			<option value="Príjemca platby aj zdroj príjmu"> Príjemca platby aj zdroj príjmu </option>	
        </select>
    </div>
  
       
    <div class="input-prepend">
        <label class="control-label">    Adresa:          </label>
        <input class="span4" type="text" name="adresa" value="<?php if (isset($editovany_zaznam[0]->t_adresa))
                                                                    echo ($editovany_zaznam[0]->t_adresa); 
                                                              ?>">
    </div>



<?php

if ($editacia == "ano") {
   echo ' <a  onClick="history.go(-1)">    <!-- Tento Javascript vložený kvôli IE - ekvivalent takisto history.back() -->
                <button type="button" class="btn btn-primary">
                    <i class="icon-remove icon-white"></i>
                        Zruš
                 </button>
           </a>';

    echo ' <button type="submit" class="btn btn-primary">
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

<h2>Zoznam partnerov</h2>

<form id="form1" name="form1" method="post" action="multizmazaniepartnerov">
  <table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th> <input type="checkbox" value="0" id="multicheck" onclick="multiCheck();" /> </th>
            <th>    Názov           </th>
            <th>    Typ partnera    </th>
            <th>    Adresa          </th>
            <th>    Výber akcie     </th>
        </tr>
    </thead>

    <tbody>
        @foreach ($partneri as $par)
        <tr>
            <td style="text-align: center;"><input type="checkbox" name="par[]" id="checkbox2" class="spendcheck" value="{{ md5($par->id). $secretword}}" /></td>
            <td>    {{ $par->t_nazov }}          </td>
			<td>	{{ $par->fl_typ }}					</td>
            <td>    {{ $par->t_adresa }}          </td>
            
            <td style="text-align: center;"> <a class="btn" href="sprava_partnerov?id={{ $par->id }}"> Upraviť </a>
                 <a class="btn" href="zmazatpartnera?id={{ md5($par->id). $secretword}}" onclick="return confirm('Naozaj chcete zmazať tento záznam?')">
                    <i class="icon-remove"> </i>Vymazať</a>      </td>
        </tr>
        @endforeach
    </tbody>
  </table>
<a class="btn" href="#" onclick="multizmazanie('par[]')"> <i class="icon-remove"> </i> Vymazať zvolené </a>
</form>


@include('foot')