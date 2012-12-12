@include('head')

<h2>Výdavky</h2>
@include('spendings/sp-submenu')
<h2>Filter výdavkov</h2>
<div class="thumbnail">
    <h4>Dátum</h4>
    <div class="input-prepend">
        <span class="add-on">Od: </span>
        <input class="span3" type="date">
    </div>
    <div class="input-prepend">
    <span class="add-on">Do: </span>
    <input class="span3" type="date">
</div>
 <div class="input-prepend">
        <span class="add-on">Príjemca: </span>
    <select class="span3">
        <option>A</option>
        <option>B</option>
        <option>C</option>
        <option>D</option>
        <option>E</option>
    </select>
     </div>
<div class="input-prepend">
        <span class="add-on">Kategória: </span>
        <select class="span3">
          @foreach ($kategorie as $kat)
            <option>{{ $kat->t_nazov }}</option>
            @endforeach
        </select>
    </div>
  <input type="button" class="btn" value="Zobraziť" />
 </div>

<h2 class="">Zoznam výdavkov</h2>
<form id="form1" name="form1" method="post" action="">
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>
                <input type="checkbox" name="checkbox" id="checkbox" />
                <label for="checkbox"></label>
            </th>
            <th>Dátum</th>
            <th>Príjemca platby</th>
            <th>Názov</th>
            <th>Suma v €</th>
            <th>Výbe akcie</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($vydavky as $vydavok)
        <tr>
            <td><input type="checkbox" name="checkbox2" id="checkbox2" /></td>
            <td>{{ $vydavok->d_datum }}</td>
            <td>{{ $vydavok->partner->t_nazov }}</td>
            <td>{{ $vydavok->t_poznamka }}</td>
            <td>{{ round($vydavok->vl_cena_so_zlavou,2) }} EUR</td>
            <td><input type="button" class="btn" value="Upraviť" />
                <input type="button" class="btn" value="Vymazať" /></td>
        </tr>
        @endforeach
        </tbody>
    </table>
</form>
<pre>

  </pre>
@include('foot');
