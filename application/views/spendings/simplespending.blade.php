@include('head')
<h2>Výdavky</h2>
@include('spendings/sp-submenu')
<h2>Jednoduchý výdavok</h2>
<div class="thumbnail">
    <h4>Syst&eacute;mov&eacute; spr&aacute;vy:</h4>
    <div class="input-prepend" style="float:left;width:295px">
        <span class="add-on">D&aacute;tum: </span>
        <input class="span3" type="date">
    </div>
<div class="input-prepend" style="float:left;width:350px">
        <span class="add-on">Dodávateľ: </span>
        <select class="span3">
        <option>A</option>
        <option>B</option>
        <option>C</option>
        <option>D</option>
        <option>E</option>
    </select>
</div>
<div class="input-prepend">
        <span class="add-on">Zaplatil: </span>
    <select class="span3">
        <option>dom&aacute;cnos&tcaron;</option>
    </select>
</div>
<div class="input-prepend">
        <span class="add-on">Poznamka: </span>
        <input class="span10" type="text">
 </div>
<hr>
<h4>Položky výdavku</h4>
<table class="table table-bordered" >
  <tr>
    <th scope="col">Položka</th>
    <th scope="col">Cena / ks</th>
    <th scope="col">Počet ks</th>
    <th scope="col">Zľava</th>
  </tr>
  <tr>
    <td height="29">
      <select name="select" class="span4">
        <option>Produkt 1</option>
        <option>Produkt 2</option>
        <option>Produkt 3</option>
        <option>Produkt 4</option>
        <option>Produkt 5</option>
      </select>
  </td>
    <td>
      <input class="span1" type="text" /> 
      EUR
    </td>
    <td>
      <input class="span1" type="text" /> 
      ks
     </td>
    <td>
      <input class="span1" type="text" />
      <select name="select2" class="span2">
        <option>Bez z&lcaron;avy</option>
        <option>Z&lcaron;ava v %</option>
        <option>Z&lcaron;ava v EUR</option>
      </select>
    </td>
  </tr>
</table>
<hr>
<div>
     <p>Celkov&aacute; z&lcaron;ava</p>
</div>
<div class="input-prepend">
        <span class="add-on">Typ z&lcaron;avy: </span>
    <select class="span3">
        <option>Bez z&lcaron;avy</option>
        <option>Z&lcaron;ava v %</option>
        <option>Z&lcaron;ava v EUR</option>
    </select>
</div>
<div class="input-prepend">
     <span class="add-on">Hodnota z&lcaron;avy: </span>
     <input class="span3" type="text">
</div>
<div class="input-prepend">
     <span class="add-on">Celkov&aacute; suma: </span>
     <input class="span3" type="text">
</div>
<div class="input-prepend">
     <span class="add-on">Celkov&aacute; z&lcaron;ava: </span>
     <input class="span3" type="text">
</div>
<div><input type="button" class="btn" value="Potvrdi&tcaron;" /></div>
<hr>
<div>
     <input type="button" class="btn" value="Vytvori&tcaron; produkt" />
</div>
@include('foot');
