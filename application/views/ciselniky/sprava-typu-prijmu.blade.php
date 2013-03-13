@include('head')

@if (isset($message) )
<h3 style="color: #bc4348;"> {{ $message }} </h3>
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
     echo "<h2>    Upravte typ prijmu   </h2>";
     echo '<form class="side-by-side" id="aktualnyformular" method="POST" action="upravtypprijmu" accept-charset="UTF-8">';  
 }
   else  {         
    echo "<h2>    Pridajte typ prijmu  </h2>";
    echo '<form class="side-by-side" id="aktualnyformular" method="POST" action="pridajtypprijmu" accept-charset="UTF-8">';
         }

?>

    <input class="span4" type="hidden" name="id" value="<?php
                                                                if (isset($editovany_zaznam[0]->id))
                                                                    echo ($editovany_zaznam[0]->id); 
                                                             ?>">
    

    <div class="input-prepend">
        <label class="control-label">    Názov typu:          </label>
        <input class="span4" type="text" name="nazov_typu" value="<?php
                                                                if (isset($editovany_zaznam[0]->t_nazov_typu))
                                                                    echo ($editovany_zaznam[0]->t_nazov_typu); 
                                                             ?>">
    </div>


<?php

if ($editacia == "ano") {
    echo ' <a  href="sprava_typu_prijmu">
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
            <td><input type="checkbox" name="typ[]" id="checkbox2" class="spendcheck" value="{{ md5($typ->id). $secretword}}" /></td>
            <td> {{ $typ->t_nazov_typu }} </td>
           
            <td> <a class="btn" href="sprava_typu_prijmu?id={{ $typ->id }}"> Upraviť </a>
                 <a class="btn" href="zmazattypprijmu?typ={{ md5($typ->id). $secretword}}" onclick="return confirm('Určite chcete zmazať tento záznam?')">
                    <i class="icon-remove"></i>Vymazať</a></td>
        </tr>
        @endforeach
    </tbody>
    
  </table>
<a class="btn" href="#" onclick="document.getElementById('form1').submit(); return false;"> <i class="icon-remove"> </i> Vymazať zvolené </a>
</form>

@include('foot')
