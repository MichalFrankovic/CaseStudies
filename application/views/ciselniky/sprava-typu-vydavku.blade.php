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
     echo "<h3>    Upraviť typ výdavku:  </h3>";
     echo '<form class="side-by-side" name="tentoForm" name="tentoForm" id="aktualnyformular" onsubmit="return validujFormTypyVydavku()" method="POST" action="upravittypvydavku" accept-charset="UTF-8">';  
 }
   else  {         
    echo "<h3>    Pridajte typ výdavku:  </h3>";
    echo '<form class="side-by-side" name="tentoForm" id="aktualnyformular" onsubmit="return validujFormTypyVydavku()" method="POST" action="pridajtypvydavku" accept-charset="UTF-8">';
         }

?>
    
            <!--  <label class="control-label">    ID OSOBY:          </label>    -->
        <input class="span4" type="hidden" name="id" value="<?php
                                                                if (isset($editovany_zaznam[0]->id))
                                                                    echo ($editovany_zaznam[0]->id); 
                                                              ?>">

    <div{{ isset($errors->typvydavku) || (is_array($errors) && isset($errors['typvydavku'])) ? ' class="control-group error"' : '' }} >
        <label class="control-label">    Názov typu výdavku:          </label>  
       <span style="padding:0px 10px;"> <input class="span4" type="text" name="nazov_typu_vydavku" value="<?php
                                                                if (isset($meneny_vydavok))
                                                                 echo $meneny_vydavok; 
                                                                elseif (isset($editovany_zaznam[0]->t_nazov_typu_vydavku))
                                                                    echo ($editovany_zaznam[0]->t_nazov_typu_vydavku); 
                                                             ?>">
</span>{{ isset($errors->typvydavku) || (is_array($errors) && isset($errors['typvydavku'])) ? '<span class="help-inline">'.$errors['typvydavku'].'</span>' : '' }}
    </div>


<a href="../ciselniky/sprava_typu_vydavku" class="btn btn-primary"> 
    <i class="icon-remove icon-white"> </i> 
        Zruš 
</a> 

<?php

if ($editacia == "ano") {

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

<h3> Zoznam typov výdavkov: </h3>


<form id="form1" name="form1" method="post" action="multizmazattypy" style="width:55%">
  <table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th> <input type="checkbox" value="0" id="multicheck" onclick="multiCheck();" /> </th>
            <th> Názov              </th>
            <th> Výber akcie </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($typy as $typ) 
        <tr>
            <td style="text-align: center;"> <input type="checkbox" name="typvydavku[]" id="checkbox2" class="spendcheck" value="{{ md5($typ->id). $secretword}}" /> </td>
            <td> {{ $typ->t_nazov_typu_vydavku }} </td>
           
            
            <td style="text-align: center;"> 
                <a class="btn btn-primary" href="sprava_typu_vydavku?id={{ $typ->id }}"> Upraviť </a>
                <a class="btn btn-danger" href="zmazattypvydavku?typvydavku={{ md5($typ->id). $secretword}}"  onclick="return confirm('Určite chcete zmazať tento záznam?')">
                <i class="icon-remove icon-white"> </i> Vymazať </a>
            </td>
        </tr>
        @endforeach
    </tbody>
    
  </table>

<a class="btn btn-danger" href="#" onclick="multizmazanie('typvydavku[]')"> <i class="icon-remove icon-white"> </i> Vymazať zvolené </a>


</form>

@include('foot') 
