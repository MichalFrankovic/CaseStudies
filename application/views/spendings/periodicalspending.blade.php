@include('head')
<h2>V&yacute;davky</h2>
@include('spendings/sp-submenu')

<h2>Pravideln&yacute;&nbsp;v&yacute;davok</h2>

<div class="thumbnail">
    <h4>Syst&eacute;mov&eacute;&nbsp;spr&aacute;vy:</h4>
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
     <select name="polozka-id" class="span4">
       <option>Varianta 1</option>
	   <option>Varianta 2</option>
	   <option>Varianta 3</option>
       <option>Varianta 4</option>
       <option>Varianta 5</option>
      </select>
</div>
</td>
<td>
<div class="input-prepend" style="float:left">
     <span class="add-on">Hodnota&nbsp;v&yacute;davku:</span>
    <input class="span3" type="text">
</div>
</td></tr>
<tr><td>
<div class="input-prepend">
    <span class="add-on">Zaplatil: </span>
    <select name="osoba" class="span3">
        @foreach ($osoby as $osoba)
        <option value="{{ $osoba->id }}"> {{$osoba->t_meno_osoby}} {{$osoba->t_priezvisko_osoby }}</option>
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

@include('foot');
