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
     echo "<h2>    Upravte typ príjmu   </h2>";
     echo '<form class="side-by-side" name="tentoForm" id="aktualnyformular" method="POST" action="upravtypprijmu" accept-charset="UTF-8">';  
 }
   else  {         
    echo "<h2>    Pridajte typ príjmu  </h2>";
    echo '<form class="side-by-side" name="tentoForm" id="aktualnyformular" method="POST" action="pridajtypprijmu" accept-charset="UTF-8">';
         }

?>

    <input class="span4" type="hidden" name="id" value="<?php
                                                                if (isset($editovany_zaznam[0]->id))
                                                                    echo ($editovany_zaznam[0]->id); 
                                                             ?>">
    

    <div {{ isset($errors->t_nazov_typu) || (is_array($errors) && isset($errors['t_nazov_typu'])) ? ' class="control-group error"' : '' }}>
        <label class="control-label">    Názov typu príjmu:          </label>
        <input class="span4" type="text" name="nazov_typu" value="<?php
                                                                if(isset($zmeneny_nazov))
                                                                   echo $zmeneny_nazov;
                                                                elseif(isset($editovany_zaznam[0]->t_nazov_typu))
                                                                       echo ($editovany_zaznam[0]->t_nazov_typu); 
                                                             ?>">
    {{ isset($errors->t_nazov_typu) || (is_array($errors) && isset($errors['t_nazov_typu'])) ? '<span class="help-inline">'.$errors['t_nazov_typu'].'</span>' : '' }}
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
   else {echo ' <a href="sprava_typu_prijmu"
                <button type="button" class="btn btn-primary">
                    <i class="icon-remove icon-white"></i>
                        Zruš
                </button>
                </a>
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


<h2 class=""> Zoznam typov príjmov </h2>

<form id="form1" name="form1" method="post" action="multitypzmazat">
  <table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th> <input type="checkbox" value="0" id="multicheck" onclick="multiCheck();" /> </th>
            <th> Názov </th>
            <th> Výber akcie </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($typy as $typ)
        <tr>
            <td style="text-align: center;"> <input type="checkbox" name="typ[]" id="checkbox2" class="spendcheck" value="{{ md5($typ->id). $secretword}}" /></td>
            <td> {{ $typ->t_nazov_typu }} </td>
           
            <td style="text-align: center;"> 
                <a class="btn btn-primary" href="sprava_typu_prijmu?id={{ $typ->id }}"> Upraviť </a>
                <a class="btn btn-danger" href="zmazattypprijmu?typ={{ md5($typ->id). $secretword}}" onclick="return confirm('Určite chcete zmazať tento záznam?')">
                    <i class="icon-remove icon-white"></i>Vymazať</a>
            </td>
        </tr>
        @endforeach
    </tbody>
    
  </table>
<a class="btn btn-danger" href="#" onclick="multizmazanie('typ[]')"> <i class="icon-remove icon-white"> </i> Vymazať zvolené </a>
</form>

@include('foot')
