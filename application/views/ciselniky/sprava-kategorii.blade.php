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
     echo "<h3>    Uprav kategóriu:   </h3>";
     echo '<form class="side-by-side" name="tentoForm" id="aktualnyformular" method="POST" action="upravkat" accept-charset="UTF-8">';  
 }
   else  {         
    echo "<h3>    Pridaj kategóriu:  </h3>";
    echo '<form class="side-by-side" name="tentoForm" id="aktualnyformular" method="POST" action="pridajkategoriu" accept-charset="UTF-8">';
         }

?>


        <input class="span4" type="hidden" name="id" value="<?php
                                                                if (isset($editovany_zaznam[0]->id))
                                                                    echo ($editovany_zaznam[0]->id); 
                                                             ?>">
    

   <div {{ isset($errors->nazov) || (is_array($errors) && isset($errors['nazov'])) ? ' class="control-group error"' : '' }}>
        <label class="control-label">    Kategória:          </label>
        <input class="span4" type="text" name="nazov" value="<?php
                                                                if (isset($editovany_zaznam[0]->t_nazov))
                                                                    echo ($editovany_zaznam[0]->t_nazov); 
                                                             ?>">
    {{ isset($errors->nazov) || (is_array($errors) && isset($errors['nazov'])) ? '<span class="help-inline">'.$errors['nazov'].'</span>' : '' }}
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



<h3>   Zoznam kategórií:    </h3>
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

    <tbody>   <?php /* To ->results je pridané len kvôli stránkovaniu */ ?>
        @foreach ($kategorie2->results as $kat)
        <tr>
            <td style="text-align: center;"> <input type="checkbox" name="kat[]" id="checkbox2" class="spendcheck" value="{{ md5($kat->id). $secretword}}" /> </td>
            <td>    {{ $kat->t_nazov }}              </td> 
            <td>    @foreach ($kategorie as $k)
                        @if($kat->id_kategoria_parent == $k->id)
                           {{$k->nazov}}   
                        @endif 
                    @endforeach                      </td>
            <td style="text-align: center;"> 
              <a class="btn btn-primary" href="sprava_kategorii?id={{ $kat->id }}"> Upraviť </a>
              <a class="btn btn-danger" href="zmazatkategoriu?kat={{ md5($kat->id). $secretword}}" onclick="return confirm('Určite chcete zmazať tento záznam?')">
                    <i class="icon-remove icon-white"> </i>Vymazať</a>      
            </td>
        </tr>
        @endforeach
    </tbody>
  </table>
  <?php /* Navigačná lista pre stránkovanie */ echo $kategorie2->links(); ?>
<a class="btn btn-danger" href="#" onclick="multizmazanie('kat[]')"> <i class="icon-remove icon-white"> </i> Vymazať zvolené </a>
</form>



@include('foot')