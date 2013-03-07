@include('head')

@if (isset($message) )
<h3 style="color: #bc4348;"> {{ $message }} </h3>
@endif

@include('ciselniky/ciselniky-podmenu')



<div class="thumbnail" >
    <h2>Pridajte typ príjmu</h2>

{{ Form::open('ciselniky/pridajtypprijmu', 'POST', array('class' => 'side-by-side','id' => 'aktualnyformular')); }}

    <div class="input-prepend">
         <label class="control-label">    Názov typu príjmu:          </label>
        <input class="span3" type="text" name="nazov_typu" value="">
    </div>

     <button onclick="formReset()" type="button" class="btn btn-primary">
        <i class="icon-remove icon-white"></i>
            Cancel
    </button>
    
    <button type="submit" class="btn btn-primary">
        <i class="icon-ok icon-white"></i>
            Pridaj
    </button>

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
           
            <td> <a class="btn" href="upravittypprijmu?id={{ $typ->id }}"> Upraviť </a>
                 <a class="btn" href="zmazattypprijmu?typ={{ md5($typ->id). $secretword}}"><i class="icon-remove"></i>Vymazať</a></td>
        </tr>
        @endforeach
    </tbody>
    
  </table>
<a class="btn" href="#" onclick="document.getElementById('form1').submit(); return false;"> <i class="icon-remove"> </i> Vymazať zvolené </a>
</form>

@include('foot')
