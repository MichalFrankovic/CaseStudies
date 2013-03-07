@include('head')

@if (isset($message) )
<h3 style="color: #bc4348;"> {{ $message }} </h3>
@endif

@include('ciselniky/ciselniky-podmenu')

Toto je sprava typu prijmu

<h2>Pridajte typ prijmu</h2>
<div class="thumbnail" >

    {{ Form::open('ciselniky/pridajtyp', 'POST', array('class' => 'side-by-side')); }}

    <div class="input-prepend" style="float:left;width:275px">
        <span class="add-on">Názov typ prijmu: </span>

        <input class="span3" type="text" name="nazov_typu" value="">
    </div>

    
   <div class="submit">
        {{ Form::submit('Uložiť' , array('class' => 'btn')); }}
    </div>
     {{ Form::close() }}
</div>

<h2 class=""> Zoznam typu prijmu </h2>

<form id="form1" name="form1" method="post" action="multitypzmazat">
  <table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th> <input type="checkbox" value="0" id="multicheck" onclick="multiCheck();" /> </th>
            <th> ID </th>
            <th> Názov </th>
            <th> Výber akcie </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($typy as $typ)
        <tr>
            <td><input type="checkbox" name="typ[]" id="checkbox2" class="spendcheck" value="{{ md5($typ->id). $secretword}}" /></td>
            <td> {{ $typ->id }} </td>
            <td> {{ $typ->t_nazov_typu }} </td>
           
            
            <td> <a class="btn" href="upravittyp?id={{ $typ->id }}"> Upraviť </a>
                 <a class="btn" href="zmazattyp?typ={{ md5($typ->id). $secretword}}"><i class="icon-remove"></i>Vymazať</a></td>
        </tr>
        @endforeach
    </tbody>
    
  </table>
<a class="btn" href="#" onclick="document.getElementById('form1').submit(); return false;"> <i class="icon-remove"> </i> Vymazať zvolené </a>
</form>
@include('foot')
