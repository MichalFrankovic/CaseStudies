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
     echo "<h2>    Upravit typ vydavku   </h2>";
     echo '<form class="side-by-side" id="aktualnyformular" method="POST" action="upravittypvydavku" accept-charset="UTF-8">';  
 }
   else  {         
    echo "<h2>    Pridajte typ vydavku  </h2>";
    echo '<form class="side-by-side" id="aktualnyformular" method="POST" action="pridajtypvydavku" accept-charset="UTF-8">';
         }

?>
    
      <!--  <label class="control-label">    ID OSOBY:          </label>    -->
        <input class="span4" type="hidden" name="id" value="<?php
                                                                if (isset($editovany_zaznam[0]->id))
                                                                    echo ($editovany_zaznam[0]->id); 
                                                             ?>">

    <div class="input-prepend">
        <label class="control-label">    Názov typu výdavku:          </label>  
       <span style="padding:0px 10px;"> <input class="span3" type="text" name="nazov_typu_vydavku" value="<?php
                                                                if (isset($editovany_zaznam[0]->t_nazov_typu_vydavku))
                                                                    echo ($editovany_zaznam[0]->t_nazov_typu_vydavku); 
                                                             ?>"></span>
    </div>

    <?php

if ($editacia == "ano") {
    echo ' <a  href="sprava_typu_vydavku">
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
   else {

         echo ' <button type="submit" class="btn btn-primary">
                    <i class="icon-ok icon-white"></i>
                        Pridaj
                </button>
              ';

        }

?>

{{ Form::close() }}
     

</div>

<h2 class=""> Zoznam typov výdavkov </h2>


<form id="form1" name="form1" method="post" action="multizmazattypy" >
  <table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th> <input type="checkbox" value="0" id="multicheck" onclick="multiCheck();" /> </th>
            <th> Názov 				</th>
            <th> Výber akcie </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($typy as $typ)
        <tr>
            <td><input type="checkbox" name="typvydavku[]" id="checkbox2" class="spendcheck" value="{{ md5($typ->id). $secretword}}" /></td>
            <td> {{ $typ->t_nazov_typu_vydavku }} </td>
           
            
            <td> <a class="btn" href="sprava_typu_vydavku?id={{ $typ->id }}"> Upraviť </a>
                 <a class="btn" href="zmazattypvydavku?typvydavku={{ md5($typ->id). $secretword}}"  onclick="return confirm('Určite chcete zmazať tento záznam?')">
                 <i class="icon-remove"></i>Vymazať</a></td>
        </tr>
        @endforeach
    </tbody>
    
  </table>
<a class="btn" href="#" onclick="document.getElementById('form1').submit(); return false;"> <i class="icon-remove"> </i> Vymazať zvolené </a>
</form>

@include('foot')