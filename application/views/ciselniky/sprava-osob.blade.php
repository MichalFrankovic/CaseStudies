@include('head')

@if (isset($message) )
<h3 style="color: #bc4348;">{{ $message }}</h3>
@endif

@include('ciselniky/ciselniky-podmenu')



<h2>Pridaj Osobu</h2>

<div class="thumbnail" >
    {{ Form::open('ciselniky/pridajosobu', 'POST', array('class' => 'side-by-side')); }}

    <div class="input-prepend" style="float:left;width:275px">
        <span class="add-on">Meno: </span>
        <input class="span3" type="text" name="meno" value="">
    </div>

    <div class="input-prepend" style="float:left;width:275px">
        <span class="add-on">Priezvisko: </span>
        <input class="span3" type="text" name="priezvisko" value="">
    </div>

    <div class="input-prepend" style="float:left;width:275px">
        <span class="add-on">Aktívna: </span>
        <input class="span3" type="Checkbox" name="aktivna" value="A">
    </div>


        <div class="submit">
            {{ Form::submit('Uložiť' , array('class' => 'btn')); }}
        </div>
        {{ Form::close() }}
    </div>
</div>




<h2>Zoznam osôb</h2>

<form id="form1" name="form1" method="post" action="multizmazanieosob">
  <table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th> <input type="checkbox" value="0" id="multicheck" onclick="multiCheck();" /> </th>
            <th>    ID              </th>
            <th>    Meno            </th>
            <th>    Priezvisko      </th>
            <th>    Aktívna         </th>
            <th>    Výber akcie     </th>
        </tr>
    </thead>

    <tbody>
        @foreach ($osoby as $osoba)
        <tr>
            <td><input type="checkbox" name="osoba[]" id="checkbox2" class="spendcheck" value="{{ md5($osoba->id). $secretword}}" /></td>
            <td>    {{ $osoba->id }}                    </td>
            <td>    {{ $osoba->t_meno_osoby }}          </td>
            <td>    {{ $osoba->t_priezvisko_osoby }}    </td>
            <td>    {{ $osoba->fl_aktivna }}            </td>
            <td> <a class="btn" href="upravitosobu?id={{ $osoba->id }}">Upraviť</a>
                 <a class="btn" href="zmazatosobu?osoba={{ md5($osoba->id). $secretword}}"><i class="icon-remove"></i>Vymazať</a></td>
        </tr>
        @endforeach
    </tbody>
  </table>
<a class="btn" href="#" onclick="document.getElementById('form1').submit(); return false;"> <i class="icon-remove"> </i> Vymazať zvolené </a>
</form>


@include('foot')