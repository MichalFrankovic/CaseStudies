@include('head')
@if (isset($message) )
    <h3 style="color: #bc8f8f;">{{ $message }}</h3>
@endif
<h2>Výdavky</h2>
@include('spendings/sp-submenu')
<h2>Šablóna výdavkov</h2>
{{ Form::open('spendings/savetemplate', 'POST', array('class' => '')); }}
<div class="input-prepend">
    <span class="add-on">Názov výdavku: </span>
    <input class="span3" type="text" name="nazov">
</div>
<div class="input-prepend">
    <span class="add-on">Príjemca platby: </span>
      <select name="dodavatel" class="span3">
        @foreach ($partneri as $partner)
        <option value="{{ $partner->id }}"> {{ $partner->t_nazov }}</option>
        @endforeach
    </select>
</div>
<div class="input-prepend">
        <span class="add-on">Pravidelnosť: </span>
    <select class="span3" name="pravidelnost">
        <option value="A">Pravidelný</option>
        <option value="N">Nepravidelný</option>
    </select>
</div>
<div class="input-prepend">
        <span class="add-on">Kategória: </span>
      <select name="polozka-id" class="span4" style="font-family: Courier, 'Courier New', monospace;" >
              @foreach ($polozky as $polozka)
                  <option value="{{ $polozka->id }}"> {{ str_replace(" ", "&nbsp;",$polozka->nazov); }}</option>
             @endforeach
      </select>
</div>
<div class="input-prepend">
    <span class="add-on">Hodnota výdavku: </span>
    <input name="hodnota" class="span3" type="text">
</div>
<input type="reset" class="btn" value="Návrat" />
<input type="submit" class="btn" value="Uložiť" />
{{ Form::close() }}
@include('foot');
