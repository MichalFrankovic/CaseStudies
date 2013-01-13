@include('head')
@if (isset($message) )
<h3 style="color: #bc4348;">{{ $message }}</h3>
@endif
<h2>Výdavky</h2>
@include('spendings/sp-submenu')
<h2>Položky IDusra: {{ $uid }}</h2>

<div class="thumbnail" >
    {{ Form::open('spendings/pridajproduktxxx', 'POST', array('class' => 'side-by-side')); }}
    <div class="input-prepend" style="float:left;width:275px">
        <span class="add-on">Názov: </span>
        <input class="span3" type="text" name="nazov" value="">
    </div>
    <div class="input-prepend">
        <span class="add-on">Základná cena:</span>
        <input class="span3" type="text" name="cena" value="">
    </div>
    <div class="input-prepend">
        <span class="add-on">Kategória: </span>
        <select name="category" class="span3">
            <option value="" selected="selected">ŽIADNA</option>
            @foreach ($kategorie as $kat)
            <option value="{{ $kat->id_kategoria_a_produkt }}">{{ $kat->t_nazov }}</option>
            @endforeach
        </select>
    </div>

        <div class="submit">
            {{ Form::submit('Uložiť' , array('class' => 'btn')); }}
        </div>
        {{ Form::close() }}
    </div>
</div>
<h2>Dodávateľ</h2>

<div class="thumbnail" >
    {{ Form::open('spendings/pridajpartnera', 'POST', array('class' => 'side-by-side')); }}
    <h4>Dátum</h4>
    <div class="input-prepend" style="float:left;width:275px">
        <span class="add-on">Názov: </span>
        <input class="span3" type="text" name="nazov-partnera" value="">
    </div>
    <div class="input-prepend">
        <span class="add-on">Adresa:</span>
        <input class="span3 " type="text" name="cena" value="">
    </div>
    <div class="submit">
        {{ Form::submit('Uložiť' , array('class' => 'btn')); }}
    </div>
    {{ Form::close() }}
</div>
</div>
@include('foot');
