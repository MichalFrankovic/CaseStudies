@include('head')

@if (isset($message) )
<h3 style="color: #bc4348;">    {{ $message }}  </h3>
@endif

@include('ciselniky/ciselniky-podmenu')


Toto je správa produktov

<h2>    Pridaj produkt  </h2>
<div class="thumbnail" >
{{ Form::open('ciselniky/pridajprodukt', 'POST', array('class' => 'side-by-side')); }}

    <div class="input-prepend" style="float:left;width:275px">
        <span class="add-on">Názov: </span>
        <input class="span3" type="text" name="nazov" value="">
    </div>

    <div class="input-prepend">
        <span class="add-on">Základná cena:</span>
        <input class="span3" type="text" name="cena" value="">
    </div>

    <div class="input-prepend">
        <span class="add-on">Kategória: </span>

        <select name="category-id" class="span3">
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
</div>




<h2 class="">   Zoznam produktov    </h2>
<form id="form1" name="form1" method="post" action="multizmazanie">
  <table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th> <input type="checkbox" value="0" id="multicheck" onclick="multiCheck();" /> </th>
            <th>    ID              </th>
            <th>    Názov           </th>
            <th>    Merná jednotka  </th>
            <th>    Základná cena   </th>
            <th>    Kategória       </th>
            <th>    Výber akcie     </th>
        </tr>
    </thead>

    <tbody>
        @foreach ($produkty as $produkt)
        <tr>
            <td><input type="checkbox" name="produkt[]" id="checkbox2" class="spendcheck" value="{{ md5($produkt->id). $secretword}}" /></td>
            <td>    {{ $produkt->id }}                           </td>
            <td>    {{ $produkt->t_nazov }}                      </td>
            <td>    {{ $produkt->t_merna_jednotka }}             </td>
            <td>    {{ round($produkt->t_vl_zakladna_cena,2) }}  </td>
            <td>    {{ $produkt->id_kategoria_parent }}          </td>
            <td> <a class="btn" href="upravitprodukt?id={{ $produkt->id }}"> Upraviť </a>
                 <a class="btn" href="zmazatprodukt?produkt={{ md5($produkt->id). $secretword}}"><i class="icon-remove"></i>Vymazať</a></td>
        </tr>
        @endforeach
    </tbody>
  </table>
<a class="btn" href="#" onclick="document.getElementById('form1').submit(); return false;"> <i class="icon-remove"> </i> Vymazať zvolené </a>
</form>



@include('foot')