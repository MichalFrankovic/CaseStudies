@include('head')
<h2>V&yacute;davky</h2>
@include('spendings/sp-submenu')

<h2>Pravideln&yacute; v&yacute;davok</h2>

<table border="0">
<tr><td>
<div class="thumbnail">
    <h4>Syst&eacute;mov&eacute; spr&aacute;vy:</h4>
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
