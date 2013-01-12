@include('head')
<h2>V&yacute;davky</h2>
@include('spendings/sp-submenu')

<h2>Pravideln&yacute; v&yacute;davok</h2>

<div class="thumbnail">
    <h4>Syst&eacute;mov&eacute; spr&aacute;vy:</h4>
<table border="0">
<tr><td>
    <div class="input-prepend" style="float:left">
          <span class="add-on">D&aacute;tum:</span>
          <input class="span3" type="date">
    </div>
</td>
<td>
<div class="input-prepend" style="float:left">
     <span class="add-on">N&aacute;zov v&yacute;davku: </span>
     <select name="polozka-id" class="span4" style="font-family: Courier, 'Courier New', monospace;" >
              @foreach ($polozky as $polozka)
                  <option value="{{ $polozka->id }}"> {{ str_replace(" ", "&nbsp;",$polozka->nazov); }}</option>
             @endforeach
      </select>
</div>
</td>
<td>
<div class="input-prepend" style="float:left">
     <span class="add-on">Hodnota v&yacute;davku:</span>
    <input class="span3" type="text">
</div>
</td></tr>
<tr><td>
<div class="input-prepend">
    <span class="add-on">Zaplatil: </span>
    <select name="osoba" class="span3">
        @foreach ($osoby as $osoba)
        <option value="{{ $osoba->id }}" @if ($vydavky[0]->id_osoba == $osoba->id) selected="selected" @endif> {{$osoba->t_meno_osoby}} {{$osoba->t_priezvisko_osoby }}</option>
        @endforeach
    </select>
</div>
</td></tr>
<tr><td>
<div>
    <input type="button" class="btn" value="Potvrdi&tcaron;" />
</div>
</td></tr>
</table>
<hr>
<h4 class="">Zoznam výdavkov</h4>
<form id="form1" name="form1" method="post" action="">
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>
                <input type="checkbox" name="checkbox" id="checkbox" />
                <label for="checkbox"></label>
            </th>
            <th>D&aacute;tum</th>
            <th>Pr&iacute;jemca platby</th>
            <th>Pravidelnos&tcaron;</th>
            <th>Kateg&oacute;ria</th>
            <th>Suma v €</th>
            <th>V&yacute;ber akcie</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><input type="checkbox" name="checkbox2" id="checkbox2" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><input type="button" class="btn" value="Upraviť" />
                <input type="button" class="btn" value="Vymazať" /></td>
        </tr>
        <tr>
            <td><input type="checkbox" name="checkbox3" id="checkbox3" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td><input type="checkbox" name="checkbox4" id="checkbox4" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        </tbody>
    </table>
</form>

@include('foot');
