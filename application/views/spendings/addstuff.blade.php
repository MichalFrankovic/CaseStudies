@include('head')
@if (isset($message) )
<h3 style="color: #bc4348;">{{ $message }}</h3>
@endif
<h2>Výdavky</h2>
@include('spendings/sp-submenu')
<h2>Pridaj Produkt</h2>

<div class="thumbnail" >
    @if ( isset($kategorie) )
    {{ Form::open('spendings/pridajprodukt', 'POST', array('class' => 'side-by-side')); }}
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

        <select name="category-id" class="span3">
            @foreach ($kategorie as $kat)
            <option value="{{ $kat->id }}">{{ $kat->t_nazov }}</option>
            @endforeach
        </select>
    </div>
    @endif

        <div class="submit">
            {{ Form::submit('Uložiť' , array('class' => 'btn')); }}
        </div>
        {{ Form::close() }}
    </div>
</div>
<h2>Pridaj kategóriu</h2>
<div class="thumbnail" >
    {{ Form::open('spendings/pridajkategoriu', 'POST', array('class' => 'side-by-side')); }}
    <div class="input-prepend" style="float:left;width:275px">
        <span class="add-on">Názov kategorie: </span>
        <input class="span3" type="text" name="nazov" value="">
    </div>
    <div class="input-prepend">
        <span class="add-on">Pod-kategória: </span>
        <select name="category-id" class="span3">
            <option value="" selected="selected">ŽIADNA</option>
            @foreach ($kategorie as $kat)
            <option value="{{ $kat->id }}">{{ $kat->t_nazov }}</option>
            @endforeach
        </select>
    </div>

    <div class="submit">
        {{ Form::submit('Uložiť' , array('class' => 'btn')); }}
    </div>
    {{ Form::close() }}
</div>
<h2>Dodávateľ</h2>

<div class="thumbnail" >
    {{ Form::open('spendings/pridajpartnera', 'POST', array('class' => 'side-by-side')); }}
    <div class="input-prepend">
        <span class="add-on">Zaplatil: </span>
        <select name="osoba" class="span3">
            @foreach ($osoby as $osoba)
            <option value="{{ $osoba->id }}" > {{ $osoba->t_meno_osoby }} {{$osoba->t_priezvisko_osoby }}</option>
            @endforeach
        </select>
    </div>
    <div class="input-prepend" style="float:left;width:275px">
        <span class="add-on">Názov: </span>
        <input class="span3" type="text" name="nazov-partnera" value="">
    </div>
    <div class="input-prepend">
        <span class="add-on">Adresa:</span>
        <input class="span3 " type="text" name="adresa" value="">
    </div>
    <div class="submit">
        {{ Form::submit('Uložiť' , array('class' => 'btn')); }}
    </div>
    {{ Form::close() }}
</div>
</div>
@include('foot');
