@include('head')

<h2>Výdavky</h2>
@include('spendings/sp-submenu')
<h2>Šablona výdavkov</h2>
<div class="input-prepend">
    <span class="add-on">N&aacute;zov v&yacute;davku: </span>
    <input class="span3" type="text">
</div>
<div class="input-prepend">
    <span class="add-on">Pr&iacute;jemca: </span>
    <select class="span3">
        <option>A</option>
        <option>B</option>
        <option>C</option>
        <option>D</option>
        <option>E</option>
    </select>
</div>
<div class="input-prepend">
        <span class="add-on">Pravidelnos&tcaron;: </span>
    <select class="span3">
        <option>Pravideln&yacute;</option>
        <option>Nepravideln&yacute;</option>
    </select>
</div>
<div class="input-prepend">
    <span class="add-on">Hodnota v&yacute;davku: </span>
    <input class="span3" type="text">
</div>
@include('foot');
