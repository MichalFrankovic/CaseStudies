@include('head')

@if (isset($message) )
<h3 style="color: #bc4348;">{{ $message }}</h3>
@endif

@include('ciselniky/ciselniky-podmenu')



<h2>Pridaj kategóriu</h2>
<div class="thumbnail" >

    {{ Form::open('ciselniky/pridajkategoriu', 'POST', array('class' => 'side-by-side')); }}

    <div class="input-prepend" style="float:left;width:275px">
        <span class="add-on">Názov kategórie: </span>

        <input class="span3" type="text" name="nazov" value="">
    </div>

    <div class="input-prepend">
        <span class="add-on">Pod-kategória: </span>

        <select name="category-id" class="span3">
            <option value="" selected="selected">ŽIADNA</option>
            @foreach ($kategorie as $kat)
            <option value="{{ $kat->id }}">{{ $kat->t_nazov }}</option>
            @endforeach
        </select>
  </div>

    <div class="submit">
        {{ Form::submit('Uložiť' , array('class' => 'btn')); }}
    </div>
        {{ Form::close() }}
</div>



<h2 class="">   Zoznam kategórií    </h2>
<form id="form1" name="form1" method="post" action="multizmazanie">
  <table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th> <input type="checkbox" value="0" id="multicheck" onclick="multiCheck();" /> </th>
            <th>    Názov kategórie      </th>
            <th>    Názov podkategórie   </th>
            <th>    Výber akcie          </th>
        </tr>
    </thead>
        <tbody>
        @foreach ($kategorie as $kat)
        <tr>
            <td> <input type="checkbox" name="kat[]" id="checkbox2" class="spendcheck" /> </td>
            <td>    {{ $kat->t_nazov }}         </td>
            <td>    {{ $kat->id }}              </td>
            <td> <a class="btn" href="upravitprodukt?id={{ $kat->id }}"> Upraviť </a>     </td>
        </tr>
        @endforeach
    </tbody>
  </table>
<a class="btn" href="#" onclick="document.getElementById('form1').submit(); return false;"> <i class="icon-remove"> </i> Vymazať zvolené </a>
</form>



@include('foot')