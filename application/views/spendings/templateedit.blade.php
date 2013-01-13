@include('head')
@if (isset($message) )
    <h3 style="color: #bc8f8f;">{{ $message }}</h3>
@endif
<h2>Výdavky</h2>
@include('spendings/sp-submenu')
<h2>Šablóna výdavkov</h2>
{{ Form::open('spendings/savetemplate?update=1', 'POST', array('class' => '')); }}
<input type="hidden" name="hlavicka-id" id="hidden" value="{{ $sablony[0]->id }}"/>
<div class="input-prepend">
    <span class="add-on">Názov výdavku: </span>
    <input class="span3" type="text" name="nazov" value="{{ $sablony[0]->t_poznamka }}" />
</div>
<div class="input-prepend">
    <span class="add-on">Príjemca platby: </span>
      <select name="dodavatel" class="span3">
        @foreach ($partneri as $partner)
        <option value="{{ $partner->id }}"{{ (($partner->id == $sablony[0]->id_obchodny_partner)? " selected" : "") }}> {{ $partner->t_nazov }}</option>
        @endforeach
    </select>
</div>
<div class="input-prepend">
        <span class="add-on">Pravidelnosť: </span>
    <select class="span3" name="pravidelnost">
        <option value="A"{{ (($sablony[0]->fl_pravidelny == 'A')? " selected" : "") }}>Pravidelný</option>
        <option value="N"{{ (($sablony[0]->fl_pravidelny == 'N')? " selected" : "") }}>Nepravidelný</option>
    </select>
</div>
<div class="input-prepend">
        <span class="add-on">Kategória: </span>
      <select name="polozka-id" class="span4" style="font-family: Courier, 'Courier New', monospace;" >
              @foreach ($polozky as $polozka)
                  <option value="{{ $polozka->id }}"{{ (($polozka->id == $sablony[0]->id_kategoria_a_produkt)? " selected" : "") }}> {{ str_replace(" ", "&nbsp;",$polozka->nazov); }}</option>
             @endforeach
      </select>
</div>
<div class="input-prepend">
    <span class="add-on">Hodnota výdavku:</span>
    <input name="hodnota" class="span3" type="text" value="{{ $sablony[0]->vl_jednotkova_cena }}" />
</div>
<a class="btn" href="periodicalspending">Návrat</a>
<input type="submit" class="btn" value="Uložiť" />
{{ Form::close() }}
@include('foot');
