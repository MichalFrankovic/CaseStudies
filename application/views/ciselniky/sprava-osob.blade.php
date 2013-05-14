@include('head')

@if(Session::get('message'))
        <div class="information {{ Session::get('status_class') }}">
            {{ Session::get('message') }}
        </div>
@endif

@include('ciselniky/ciselniky-podmenu')

<?php

if (isset($editovany_zaznam)) 
 $editacia="ano";
    else $editacia = "nie";

?>

@if (isset($error) && $error == true)
    <div class="alert alert-error">{{ $error }}</div>
@endif


<div class="thumbnail" >

<?php
if ($editacia == 'ano') {
     echo "<h3>    Uprav osobu:   </h3>";
     echo '<form class="side-by-side" name="tentoForm" id="aktualnyformular" method="POST" action="upravitosobu" accept-charset="UTF-8">';  
 }
   else  {         
    echo "<h3>    Pridaj osobu do domácnosti:  </h3>";
    echo '<form class="side-by-side" name="tentoForm" id="aktualnyformular" method="POST" action="pridajosobu" accept-charset="UTF-8">';
         }

?>
    
        <input class="span3" type="hidden" name="id" value="<?php
                                                                if (isset($editovany_zaznam[0]->id))
                                                                    echo ($editovany_zaznam[0]->id); 
                                                             ?>">
    

    <div {{ isset($errors->meno) || (is_array($errors) && isset($errors['meno'])) ? ' class="control-group error"' : '' }}>
        <label class="control-label">    Meno:          </label>
        <input class="span3" type="text" name="meno" value="<?php
                                                                if (isset($menene_meno))
                                                                echo $menene_meno;
                                                                
                                                                elseif (isset($editovany_zaznam[0]->t_meno_osoby))
                                                                    echo ($editovany_zaznam[0]->t_meno_osoby); 
                                                             ?>">
        {{ isset($errors->meno) || (is_array($errors) && isset($errors['meno'])) ? '<span class="help-inline">'.$errors['meno'].'</span>' : '' }}
    </div>


       
        <div {{ isset($errors->priezvisko) || (is_array($errors) && isset($errors['priezvisko'])) ? ' class="control-group error"' : '' }}>
        <label class="control-label">    Priezvisko:          </label>
        <input class="span3" type="text" name="priezvisko" value="<?php
                                                                if (isset($menene_priezvisko))
                                                                echo $menene_priezvisko;
                                                                elseif (isset($editovany_zaznam[0]->t_priezvisko_osoby))
                                                                    echo ($editovany_zaznam[0]->t_priezvisko_osoby); 
                                                             ?>">
        {{ isset($errors->priezvisko) || (is_array($errors) && isset($errors['priezvisko'])) ? '<span class="help-inline">'.$errors['priezvisko'].'</span>' : '' }}

    </div>


<?php 
$id = Input::get('id');
$znaky = DB::table('D_OSOBA')
->where_in('id', array($id))->get(array('id', 'fl_aktivna'));

?>


<div class="input-append">
        <label class="control-label">    Aktívna:    </label>   
        
        <?php if(isset($editovany_zaznam[0]->fl_aktivna) && ($editovany_zaznam[0]->fl_aktivna == 'A'))
         echo '<input name="aktivna"  class="span2" type="checkbox" value="A" checked>';
            else echo '<input name="aktivna"  class="span2" type="checkbox" value="A">'; 
         ?>   

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

<h3> Zoznam osôb: </h3>

<form id="form1" name="form1" method="post" action="multizmazanieosob">
  <table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th> <input type="checkbox" value="0" id="multicheck" onclick="multiCheck();" /> </th>
            <th>    Priezvisko      </th>
            <th>    Meno            </th>
            <th>    Aktívna         </th>
            <th>    Výber akcie     </th>
        </tr>
    </thead>

    <tbody>
        @foreach ($osoby as $osoba)
        <tr>
            <td style="text-align: center;"> <input type="checkbox" name="osoba[]" id="checkbox2" class="spendcheck" value="{{ md5($osoba->id). $secretword}}" /> </td>
            <td>    {{ $osoba->t_priezvisko_osoby }}    </td>
            <td>    {{ $osoba->t_meno_osoby }}          </td>
            <td>    {{ $osoba->fl_aktivna }}            </td>
            <td style="text-align: center;"> 
                <a class="btn btn-primary" href="sprava_osob?id={{ $osoba->id }}"> Upraviť </a>
                <a class="btn btn-danger" href="zmazatosobu?osoba={{ md5($osoba->id). $secretword}}" onclick="return confirm('Určite chcete zmazať tento záznam?')">
                    <i class="icon-remove icon-white"> </i>Vymazať</a>      
            </td>
        </tr>
        @endforeach
    </tbody>
  </table>
<a class="btn btn-danger" href="#" onclick="multizmazanie('osoba[]')"> <i class="icon-remove icon-white"> </i> Vymazať zvolené </a>
</form>


@include('foot')