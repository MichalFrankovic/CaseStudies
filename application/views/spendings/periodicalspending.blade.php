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
    <select class="span3">
        <option>&nbsp;</option>
        <option>&Scaron;abl&oacute;na 1</option>
        <option>&Scaron;abl&oacute;na 2</option>
        <option>&Scaron;abl&oacute;na 3</option>
        <option>&Scaron;abl&oacute;na 4</option>
        <option>&Scaron;abl&oacute;na 5</option>
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
        <option>&Zcaron;atkovci</option>
        <option>otec&nbsp;&Zcaron;atko</option>
        <option>matka&nbsp;&Zcaron;atkov&aacute;</option>
        <option>syn&nbsp;&Zcaron;atko</option>
        <option>dc&eacute;ra&nbsp;Z&aacute;vodn&aacute;</option>
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
