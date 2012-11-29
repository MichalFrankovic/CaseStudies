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
            <option>A</option>
            <option>B</option>
            <option>C</option>
            <option>D</option>
            <option>E</option>
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
            <th>Kategória</th>
            <th>Suma v €</th>
            <th>Výbe akcie</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><input type="checkbox" name="checkbox2" id="checkbox2" /></td>
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
        </tr>
        <tr>
            <td><input type="checkbox" name="checkbox4" id="checkbox4" /></td>
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
