@include('head')

@if (isset($message) )
<h3 style="color: #bc4348;">{{ $message }}</h3>
@endif

@include('ciselniky/ciselniky-podmenu')


<div class="thumbnail" >
    <h2>Pridaj osobu</h2>

{{ Form::open('ciselniky/pridajosobu', 'POST', array('class' => 'side-by-side','id' => 'aktualnyformular')); }}

    <div class="input-prepend">
        <label class="control-label">    Meno:          </label>
        <input class="span3" type="text" name="meno" value="">
    </div>

    <div class="input-prepend">
        <label class="control-label">    Priezvisko:    </label>     
        <input class="span3" type="text" name="priezvisko" value="">
    </div>

    <div class="input-prepend">
        <label class="control-label">    Aktívna:       </label>
        <input class="span3" type="Checkbox" name="aktivna" value="A">
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



<h2>Zoznam osôb</h2>

<form id="form1" name="form1" method="post" action="multizmazanieosob">
  <table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th> <input type="checkbox" value="0" id="multicheck" onclick="multiCheck();" /> </th>
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