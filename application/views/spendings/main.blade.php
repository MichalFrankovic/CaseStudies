@include('head')
@if (isset($message) )
    <h3 style="color: #bc4348;">{{ $message }}</h3>
@endif
<h2>Výdavky</h2>
@include('spendings/sp-submenu')
<h2>Filter výdavkov</h2>
{{ Form::open('spendings/filter', 'POST', array('class' => 'side-by-side')); }}
<div class="thumbnail" >
    <h4>Dátum</h4>
    <div class="input-prepend" style="float:left;width:275px">
        <span class="add-on">Od: </span>
        <input class="span3 datepicker" type="text" name="od" value="{{ $od }}">
    </div>
    <div class="input-prepend">
    <span class="add-on">Do: </span>
    <input class="span3 datepicker" type="text" name="do" value="{{ $do }}">
</div>
 <div class="input-prepend">
        <span class="add-on">Príjemca: </span>
    <select name="prijemca" class="span3">
        <option value="all" selected="selected">VŠETCI</option>
        @foreach ($partneri as $partner)
        <option value="{{ $partner->id }}"> {{ $partner->t_nazov }}</option>
        @endforeach
    </select>
     </div>
    <span>Filtrovanie podla kategorii je nefunkcne</span>
<div class="input-prepend">

        <span class="add-on">Kategória: </span>
        <select name="category" class="span3">
          @foreach ($kategorie as $kat)
            <option value="{{ $kat->id_kategoria_a_produkt }}">{{ $kat->t_nazov }}</option>
            @endforeach
        </select>
    <div class="submit">
        {{ Form::submit('Zobraziť' , array('class' => 'btn')); }}
    </div>
    {{ Form::close() }}
    </div>
 </div>

<script type="text/javascript">
function multiCheck()
{
	var valChecked = $('#multicheck').val();
	if(valChecked == 0)
	{
		$('.spendcheck').prop('checked', true);
		$('#multicheck').val(1);
	}
	else
	{
		$('.spendcheck').prop('checked', false);
		$('#multicheck').val(0);
	}
}
</script>

<h2 class="">Zoznam výdavkov</h2>
<form id="form1" name="form1" method="post" action="multideletespending">
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th><input type="checkbox" value="0" id="multicheck" onclick="multiCheck();" /></th>
            <th>Dátum</th>
            <th>Príjemca platby</th>
            <th>Názov</th>
            <th>Suma v €</th>
            <th>Výber akcie</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($vydavky as $vydavok)
        <tr>
            <td><input type="checkbox" name="vydavok[]" id="checkbox2" class="spendcheck" value="{{ md5($vydavok->id). $secretword}}" /></td>
            <td>{{ date('d.m.Y',strtotime($vydavok->d_datum)) }}</td>
            <td>{{ $vydavok->partner->t_nazov }}</td>
            <td>{{ $vydavok->t_poznamka }}</td>
            <td>{{ round($vydavok->suma_vydavku_po_celk_zlave,2) }} EUR</td>
            <td><a class="btn" href="simplespending?id={{ $vydavok->id }}">Upraviť</a>
                <a class="btn" href="deletespending?vydavok={{ md5($vydavok->id). $secretword}}"><i class="icon-remove"></i>Vymazať</a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
    <a class="btn" href="#" onclick="document.getElementById('form1').submit(); return false;"><i class="icon-remove"></i>Vymazať zvolené</a>
</form>

@include('foot');
